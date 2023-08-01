<?php

namespace ConfrariaWeb\Address\Services;

use ConfrariaWeb\Address\Models\Country;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CountryService
{

    public function __construct()
    {
        //
    }

    public function all()
    {
        return Country::all();
    }

    public function create(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'code' => 'required|string|max:2',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'code_phone' => 'nullable|string|max:5',
                'lang' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            return Country::create($data);
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
                'code' => 'required|string|max:2',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'code_phone' => 'nullable|string|max:5',
                'lang' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $country = Country::find($id);
            if (!$country) {
                throw new \Exception('Country not found');
            }

            $country->fill($data);
            $country->save();

            return $country;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }

    public function delete($id)
    {
        try {
            $country = Country::find($id);
            if (!$country) {
                throw new \Exception('Country not found');
            }

            $country->delete();

            return true;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }
}
