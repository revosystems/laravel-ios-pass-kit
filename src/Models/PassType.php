<?php

namespace RevoSystems\iOSWallet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PassType extends Model
{
    protected $guarded = [];

    use SoftDeletes;

    public function passes()
    {
        return $this->hasMany(Pass::class);
    }

}