<?php

namespace ConfrariaWeb\Address\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Street extends Model
{

    use SoftDeletes;

    protected $table = 'address_streets';

    protected $fillable = [
        'city_id',
        'neighborhood_id',
        'zip_code',
        'name',
        'slug',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class, 'neighborhood_id');
    }

    public function addresses()
    {
        return $this->hasMany(AddressModel::class, 'street_id');
    }
}
