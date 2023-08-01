<?php

namespace ConfrariaWeb\Address\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CityZone extends Model
{
    use SoftDeletes;

    protected $table = 'address_city_zones';

    protected $fillable = [
        'city_id',
        'name',
        'slug',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

}
