<?php

namespace ConfrariaWeb\Address\Services;

use ConfrariaWeb\Address\Models\CityZone;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CityZoneService
{

    public function __construct()
    {
        //
    }

    public function all()
    {
        return CityZone::all();
    }

    public function create(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'city_id' => 'required|exists:address_cities,id',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            return CityZone::create($data);
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
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $cityZone = CityZone::find($id);
            if (!$cityZone) {
                throw new \Exception('City Zone not found');
            }

            $cityZone->fill($data);
            $cityZone->save();

            return $cityZone;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }

    public function delete($id)
    {
        try {
            $cityZone = CityZone::find($id);
            if (!$cityZone) {
                throw new \Exception('City Zone not found');
            }

            $cityZone->delete();

            return true;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }
}
