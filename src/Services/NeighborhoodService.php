<?php

namespace ConfrariaWeb\Address\Services;

use ConfrariaWeb\Address\Models\Neighborhood;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class NeighborhoodService
{

    public function __construct()
    {
        //
    }

    public function all()
    {
        return Neighborhood::all();
    }

    public function create(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'city_id' => 'required|exists:address_cities,id',
                'zone_id' => 'nullable|exists:address_city_zones,id',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            return Neighborhood::create($data);
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
                'zone_id' => 'nullable|exists:address_city_zones,id',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $neighborhood = Neighborhood::find($id);
            if (!$neighborhood) {
                throw new \Exception('Neighborhood not found');
            }

            $neighborhood->fill($data);
            $neighborhood->save();

            return $neighborhood;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }

    public function delete($id)
    {
        try {
            $neighborhood = Neighborhood::find($id);
            if (!$neighborhood) {
                throw new \Exception('Neighborhood not found');
            }

            $neighborhood->delete();

            return true;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }
}
