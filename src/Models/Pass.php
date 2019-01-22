<?php

namespace RevoSystems\iOSWallet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pass extends Model
{
    protected $guarded = [];

    use SoftDeletes;

    public function passType()
    {
        return $this->belongsTo(PassType::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}