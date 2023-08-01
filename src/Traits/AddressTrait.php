<?php

namespace ConfrariaWeb\Address\Traits;

trait AddressTrait
{

    public function addresses()
    {
        return $this->morphMany('ConfrariaWeb\Address\Models\Address', 'addressable');
    }
}
