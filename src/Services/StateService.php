<?php

namespace ConfrariaWeb\Address\Services;

use ConfrariaWeb\Address\Models\State;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StateService
{

    public function __construct()
    {
        //
    }

    public function all()
    {
        return State::all();
    }

    public function create(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'country_id' => 'required|exists:address_countries,id',
                'country_region_id' => 'nullable|exists:address_country_regions,id',
                'code' => 'required|string|max:2',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            return State::create($data);
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
                'country_id' => 'required|exists:address_countries,id',
                'country_region_id' => 'nullable|exists:address_country_regions,id',
                'code' => 'required|string|max:2',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $state = State::find($id);
            if (!$state) {
                throw new \Exception('State not found');
            }

            $state->fill($data);
            $state->save();

            return $state;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }

    public function delete($id)
    {
        try {
            $state = State::find($id);
            if (!$state) {
                throw new \Exception('State not found');
            }

            $state->delete();

            return true;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }
}
