<?php

namespace ConfrariaWeb\Address\Services;

use ConfrariaWeb\Address\Models\CountryRegion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CountryRegionService
{

    public function __construct()
    {
        //
    }

    public function all()
    {
        return CountryRegion::all();
    }

    public function create(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'country_id' => 'required|exists:address_countries,id',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            return CountryRegion::create($data);
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
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $countryRegion = CountryRegion::find($id);
            if (!$countryRegion) {
                throw new \Exception('Country Region not found');
            }

            $countryRegion->fill($data);
            $countryRegion->save();

            return $countryRegion;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }

    public function delete($id)
    {
        try {
            $countryRegion = CountryRegion::find($id);
            if (!$countryRegion) {
                throw new \Exception('Country Region not found');
            }

            $countryRegion->delete();

            return true;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }
}
