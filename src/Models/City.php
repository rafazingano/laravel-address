<?php

namespace ConfrariaWeb\Address\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{

    use SoftDeletes;

    protected $table = 'address_cities';

    protected $fillable = [
        'state_id',
        'state_micro_region_id',
        'name',
        'slug',
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function stateMicroRegion()
    {
        return $this->belongsTo(StateMicroRegion::class, 'state_micro_region_id');
    }

    public function zones()
    {
        return $this->hasMany(CityZone::class, 'city_id');
    }

    public function neighborhoods()
    {
        return $this->hasMany(Neighborhood::class, 'city_id');
    }
}
