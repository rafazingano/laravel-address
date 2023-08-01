<?php

namespace ConfrariaWeb\Address\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StateMicroRegion extends Model
{

    use SoftDeletes;

    protected $table = 'address_state_micro_regions';

    protected $fillable = [
        'state_id',
        'state_meso_region_id',
        'name',
        'slug',
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    
    public function mesoRegion()
    {
        return $this->belongsTo(StateMesoRegion::class, 'state_meso_region_id');
    }

}
