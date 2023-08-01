<?php

namespace ConfrariaWeb\Address\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{

    use SoftDeletes;

    protected $table = 'addresses';

    protected $fillable = [
        'street_id',
        'number',
        'complement',
    ];

    public function street()
    {
        return $this->belongsTo(Street::class, 'street_id');
    }

    public function addressable()
    {
        return $this->morphTo();
    }
}
