<?php

namespace ConfrariaWeb\Address\Services;

use ConfrariaWeb\Address\Models\City;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CityService
{

    public function __construct()
    {
        //
    }

    public function all()
    {
        return City::all();
    }

    public function create(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'state_id' => 'required|exists:address_states,id',
                'state_micro_region_id' => 'nullable|exists:address_state_micro_regions,id',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            return City::create($data);
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
                'state_micro_region_id' => 'nullable|exists:address_state_micro_regions,id',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $city = City::find($id);
            if (!$city) {
                throw new \Exception('City not found');
            }

            $city->fill($data);
            $city->save();

            return $city;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }

    public function delete($id)
    {
        try {
            $city = City::find($id);
            if (!$city) {
                throw new \Exception('City not found');
            }

            $city->delete();

            return true;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }
}
