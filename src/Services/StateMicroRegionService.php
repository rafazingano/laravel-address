<?php

namespace ConfrariaWeb\Address\Services;

use ConfrariaWeb\Address\Models\StateMicroRegion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StateMicroRegionService
{

    public function __construct()
    {
        //
    }

    public function all()
    {
        return StateMicroRegion::all();
    }

    public function create(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'state_meso_region_id' => 'required|exists:address_state_meso_regions,id',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            return StateMicroRegion::create($data);
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }

    public function update(array $data, $id)
    {
        try {
            $validator = Validator::make($data, [
                'state_meso_region_id' => 'required|exists:address_state_meso_regions,id',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $stateMicroRegion = StateMicroRegion::find($id);
            if (!$stateMicroRegion) {
                throw new \Exception('State Micro Region not found');
            }

            $stateMicroRegion->fill($data);
            $stateMicroRegion->save();

            return $stateMicroRegion;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }

    public function delete($id)
    {
        try {
            $stateMicroRegion = StateMicroRegion::find($id);
            if (!$stateMicroRegion) {
                throw new \Exception('State Micro Region not found');
            }

            $stateMicroRegion->delete();

            return true;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }
}
