<?php

namespace ConfrariaWeb\Address\Services;

use ConfrariaWeb\Address\Models\Address;
use ConfrariaWeb\Address\Models\City;
use ConfrariaWeb\Address\Models\Country;
use ConfrariaWeb\Address\Models\CountryRegion;
use ConfrariaWeb\Address\Models\Neighborhood;
use ConfrariaWeb\Address\Models\State;
use ConfrariaWeb\Address\Models\StateMicroRegion;
use ConfrariaWeb\Address\Models\StateMesoRegion;
use ConfrariaWeb\Address\Models\Street;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AddressService
{

    protected $data;

    public function __construct()
    {
        //
    }

    public function all()
    {
        return Address::all();
    }

    public function create(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'street_id' => 'required|exists:address_streets,id',
                'addressable_id' => 'required|integer',
                'addressable_type' => 'required|string',
                'number' => 'nullable|integer',
                'complement' => 'nullable|json',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            return Address::create($data);
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
                'street_id' => 'required|exists:address_streets,id',
                'addressable_id' => 'required|integer',
                'addressable_type' => 'required|string',
                'number' => 'nullable|integer',
                'complement' => 'nullable|json',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $address = Address::find($id);
            if (!$address) {
                throw new \Exception('Address not found');
            }

            $address->fill($data);
            $address->save();

            return $address;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }

    public function delete($id)
    {
        try {
            $address = Address::find($id);
            if (!$address) {
                throw new \Exception('Address not found');
            }

            $address->delete();

            return true;
        } catch (\Exception $e) {
            // Tratamento de exceção
            // Registre os logs de erro, se necessário
            // Retorne false ou outra resposta adequada para indicar o erro
        }
    }
    
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function firstOrCreateInCascade()
    {
        return DB::transaction(function () {
            try {
                $this->validateData();

                $country = $this->getCountry();
                $countryRegion = $this->getCountryRegion($country);
                $state = $this->getState($country, $countryRegion);
                $stateMesoRegion = $this->getStateMesoRegion($state);
                $stateMicroRegion = $this->getStateMicroRegion($stateMesoRegion);
                $city = $this->getCity($state, $stateMicroRegion);
                $neighborhood = $this->getNeighborhood($city);
                $street = $this->getStreet($city, $neighborhood);
                $address = $this->getAddress($street);

                return $address;
            } catch (\Exception $e) {
                // Tratamento de exceção
                // Registre os logs de erro, se necessário
                // Retorne false ou outra resposta adequada para indicar o erro
            }
        });
    }

    protected function validateData()
    {
        $validator = Validator::make($this->data, [
            'country' => 'required|string',
            'country_region' => 'nullable|string',
            'state' => 'nullable|string',
            'state_meso_region' => 'nullable|string',
            'state_micro_region' => 'nullable|string',
            'city' => 'nullable|string',
            'neighborhood' => 'nullable|string',
            'street' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    protected function getCountry()
    {
        $country = null;
        if (isset($this->data['country'])) {
            $country = Country::firstOrCreate(['name' => $this->data['country']]);
        } elseif (isset($this->data['country_id'])) {
            $country = Country::find($this->data['country_id']);
        }
        return $country;
    }

    protected function getCountryRegion($country)
    {
        $countryRegion = null;
        if (isset($this->data['country_region'])) {
            $countryRegion = CountryRegion::firstOrCreate([
                'country_id' => $country->id,
                'name' => $this->data['country_region'],
            ]);
        } elseif (isset($this->data['country_region_id'])) {
            $countryRegion = CountryRegion::find($this->data['country_region_id']);
        }
        return $countryRegion;
    }

    protected function getState($country, $countryRegion)
    {
        $state = null;
        if (isset($this->data['state'])) {
            $state = State::firstOrCreate([
                'country_id' => $country->id,
                'country_region_id' => $countryRegion ? $countryRegion->id : null,
                'name' => $this->data['state'],
            ]);
        } elseif (isset($this->data['state_id'])) {
            $state = State::find($this->data['state_id']);
        }
        return $state;
    }

    protected function getStateMesoRegion($state)
    {
        $stateMesoRegion = null;
        if (isset($this->data['state_meso_region'])) {
            $stateMesoRegion = StateMesoRegion::firstOrCreate([
                'state_id' => $state ? $state->id : null,
                'name' => $this->data['state_meso_region'],
            ]);
        } elseif (isset($this->data['state_meso_region_id'])) {
            $stateMesoRegion = StateMesoRegion::find($this->data['state_meso_region_id']);
        }
        return $stateMesoRegion;
    }

    protected function getStateMicroRegion($stateMesoRegion)
    {
        $stateMicroRegion = null;
        if (isset($this->data['state_micro_region'])) {
            $stateMicroRegion = StateMicroRegion::firstOrCreate([
                'state_meso_region_id' => $stateMesoRegion ? $stateMesoRegion->id : null,
                'name' => $this->data['state_micro_region'],
            ]);
        } elseif (isset($this->data['state_micro_region_id'])) {
            $stateMicroRegion = StateMicroRegion::find($this->data['state_micro_region_id']);
        }
        return $stateMicroRegion;
    }

    protected function getCity($state, $stateMicroRegion)
    {
        $city = null;
        if (isset($this->data['city'])) {
            $city = City::firstOrCreate([
                'state_id' => $state ? $state->id : null,
                'state_micro_region_id' => $stateMicroRegion ? $stateMicroRegion->id : null,
                'name' => $this->data['city'],
            ]);
        } elseif (isset($this->data['city_id'])) {
            $city = City::find($this->data['city_id']);
        }
        return $city;
    }

    protected function getNeighborhood($city)
    {
        $neighborhood = null;
        if (isset($this->data['neighborhood'])) {
            $neighborhood = Neighborhood::firstOrCreate([
                'city_id' => $city ? $city->id : null,
                'name' => $this->data['neighborhood'],
            ]);
        } elseif (isset($this->data['neighborhood_id'])) {
            $neighborhood = Neighborhood::find($this->data['neighborhood_id']);
        }
        return $neighborhood;
    }

    protected function getStreet($city, $neighborhood)
    {
        $street = null;
        if (isset($this->data['street'])) {
            $street = Street::firstOrCreate([
                'city_id' => $city ? $city->id : null,
                'neighborhood_id' => $neighborhood ? $neighborhood->id : null,
                'name' => $this->data['street'],
            ]);
        } elseif (isset($this->data['street_id'])) {
            $street = Street::find($this->data['street_id']);
        }
        return $street;
    }

    protected function getAddress($street)
    {
        $addressData = [
            'street_id' => $street ? $street->id : null,
            'addressable_id' => isset($this->data['addressable_id']) ? $this->data['addressable_id'] : null,
            'addressable_type' => isset($this->data['addressable_type']) ? $this->data['addressable_type'] : null,
            'number' => isset($this->data['number']) ? $this->data['number'] : null,
            'complement' => isset($this->data['complement']) ? $this->data['complement'] : null,
        ];
        $address = Address::firstOrCreate($addressData);
        return $address;
    }
}
