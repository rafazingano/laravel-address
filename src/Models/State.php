<?php

namespace ConfrariaWeb\Address\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use SoftDeletes;

    protected $table = 'address_states';

    protected $fillable = [
        'country_id',
        'country_region_id',
        'code',
        'name',
        'slug',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function countryRegion()
    {
        return $this->belongsTo(CountryRegion::class, 'country_region_id');
    }

    public function mesoRegions()
    {
        return $this->hasMany(StateMesoRegion::class, 'state_id');
    }

    public function microRegions()
    {
        return $this->hasMany(StateMicroRegion::class, 'state_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'state_id');
    }
}
