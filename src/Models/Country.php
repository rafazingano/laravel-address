<?php

namespace ConfrariaWeb\Address\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{

    use SoftDeletes;

    protected $table = 'address_countries';

    protected $fillable = [
        'code',
        'name',
        'slug',
        'code_phone',
        'lang',
    ];

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function regions()
    {
        return $this->hasMany(CountryRegion::class);
    }

    public function cities()
    {
        return $this->hasManyThrough(City::class, State::class);
    }

}
