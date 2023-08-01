<?php

namespace ConfrariaWeb\Address\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Neighborhood extends Model
{

    use SoftDeletes;

    protected $table = 'address_neighborhoods';

    protected $fillable = [
        'city_id',
        'zone_id',
        'name',
        'slug',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function cityZone()
    {
        return $this->belongsTo(CityZone::class, 'zone_id');
    }

    public function streets()
    {
        return $this->hasMany(Street::class, 'neighborhood_id');
    }
}
