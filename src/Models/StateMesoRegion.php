<?php

namespace ConfrariaWeb\Address\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StateMesoRegion extends Model
{

    use SoftDeletes;

    protected $table = 'address_state_meso_regions';

    protected $fillable = [
        'state_id',
        'name',
        'slug',
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

}
