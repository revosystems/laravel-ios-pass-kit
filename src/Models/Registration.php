<?php

namespace RevoSystems\iOSWallet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    public function passes()
    {
        return $this->hasMany(Pass::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}