<?php

namespace RevoSystems\iOSWallet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    protected $table    = config('wallet.devices_table', 'devices');
    protected $guarded  = [];

    use SoftDeletes;

    public function passes()
    {
        return $this->hasMany(Pass::class);
    }

    public function register($serialNumber)
    {
        Registration::firstOrCreate([
            "device_id" => $this->id,
            "pass_id"   => Pass::where(config('wallet.serial_number_field', 'serial_number'), $serialNumber)->firstOrFail(),
        ]);

    }
    public function unRegister($serialNumber)
    {
        $this->passes() /* Only have one passType ->where('passType', $passType) */
            ->where(config('wallet.serial_number_field', 'serial_number'), $serialNumber)
            ->delete();
        if ($this->hasNot('passes')) {
            $this->delete();
        }
    }
}
