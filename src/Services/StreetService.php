<?php

namespace ConfrariaWeb\Address\Services;

use ConfrariaWeb\Address\Models\Street;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StreetService
{

    public function __construct()
    {
        //
    }

    public function all()
    {
        return Street::all();
    }

    public function create(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'city_id' => 'required|exists:address_cities,id',
                'neighborhood_id' => 'nullable|exists:address_neighborhoods,id',
                'zip_code' => 'nullable|string|max:9',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            return Street::create($data);
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
                'city_id' => 'required|exists:address_cities,id',
                'neighborhood_id' => 'nullable|exists:address_neighborhoods,id',
                'zip_code' => 'nullable|string|max:9',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $street = Street::find($id);
            if (!$street) {
                throw new \Exception('Street not found');
            }

            $street->fill($data);
            $street->save();

            return $street;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }

    public function delete($id)
    {
        try {
            $street = Street::find($id);
            if (!$street) {
                throw new \Exception('Street not found');
            }

            $street->delete();

            return true;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }
}
