<?php

namespace RevoSystems\iOSWallet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    protected $guarded = [];

    use SoftDeletes;

    public function passes()
    {
        return $this->hasMany(Pass::class);
    }
    
    public function unRegister($passType, $serialNumber)
    {
        $this->passes()->where('passType', $passType)
            ->where('serialNumber', $serialNumber)
            ->delete();
//        if (! $device->passes()->count()) {
        if ($this->hasNot('passes')) {
            $this->delete();
        }
    }
}