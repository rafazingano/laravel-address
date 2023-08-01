<?php

namespace ConfrariaWeb\Address\Services;

use ConfrariaWeb\Address\Models\StateMesoRegion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StateMesoRegionService
{

    public function __construct()
    {
        //
    }

    public function all()
    {
        return StateMesoRegion::all();
    }

    public function create(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'state_id' => 'required|exists:address_states,id',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            return StateMesoRegion::create($data);
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
                'state_id' => 'required|exists:address_states,id',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $stateMesoRegion = StateMesoRegion::find($id);
            if (!$stateMesoRegion) {
                throw new \Exception('State Meso Region not found');
            }

            $stateMesoRegion->fill($data);
            $stateMesoRegion->save();

            return $stateMesoRegion;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }

    public function delete($id)
    {
        try {
            $stateMesoRegion = StateMesoRegion::find($id);
            if (!$stateMesoRegion) {
                throw new \Exception('State Meso Region not found');
            }

            $stateMesoRegion->delete();

            return true;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }
}
