<?php

namespace ConfrariaWeb\Address\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CountryRegion extends Model
{

    use SoftDeletes;

    protected $table = 'address_country_regions';

    protected $fillable = [
        'country_id',
        'name',
        'slug',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function states()
    {
        return $this->hasMany(State::class, 'country_region_id');
    }
}
