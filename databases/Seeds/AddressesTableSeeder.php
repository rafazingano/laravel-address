<?php
namespace ConfrariaWeb\Address\Databases\Seeds;

use Illuminate\Database\Seeder;
use ConfrariaWeb\Address\Models\City;
use ConfrariaWeb\Address\Models\Country;
use ConfrariaWeb\Address\Models\CountryRegion;
use ConfrariaWeb\Address\Models\Neighborhood;
use ConfrariaWeb\Address\Models\State;
use ConfrariaWeb\Address\Models\StateMesoRegion;
use ConfrariaWeb\Address\Models\StateMicroRegion;

class AddressesTableSeeder extends Seeder
{

    public function run()
    {
        
        $json = $this->lists("https://servicodados.ibge.gov.br/api/v1/localidades/municipios");
        //$json = $this->lists("https://servicodados.ibge.gov.br/api/v1/localidades/distritos");
        
        $country = Country::firstOrCreate(['name' => 'Brasil', 'code_phone' => '+55', 'lang' => 'pt-br']);
        foreach ($json as $address) {
            $countryRegion = CountryRegion::firstOrCreate(
                [
                    'name' => $address['microrregiao']['mesorregiao']['UF']['regiao']['nome'],
                    'country_id' => $country->id
                ]
            );

            $state = State::firstOrCreate(
                [
                    'name' => $address['microrregiao']['mesorregiao']['UF']['nome'],
                    'country_id' => $country->id
                ],
                [
                    'country_region_id' => $countryRegion->id,
                    'code' => $address['microrregiao']['mesorregiao']['UF']['sigla']
                ]
            );

            $stateMesoRegion = StateMesoRegion::firstOrCreate(
                [
                    'name' => $address['microrregiao']['mesorregiao']['nome'],
                    'state_id' => $state->id
                ]
            );

            $stateMicroRegion = StateMicroRegion::firstOrCreate(
                [
                    'name' => $address['microrregiao']['nome'],
                    'state_meso_region_id' => $stateMesoRegion->id
                ]
            );

            $city = City::firstOrCreate(
                [
                    'name' => $address['nome'],
                    'state_id' => $state->id,
                    'state_micro_region_id' => $stateMicroRegion->id
                ]
            );

            $neighborhood = Neighborhood::firstOrCreate(
                [
                    'name' => $address['nome'],
                    'city_id' => $city->id,
                ]
            );
        }
        
    }

    private function lists($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }
}
