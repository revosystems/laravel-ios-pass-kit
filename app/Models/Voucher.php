<?php

namespace RevoSystems\Demo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RevoSystems\iOSPassKit\Traits\PassKitTrait;

class Voucher extends Model
{
    use SoftDeletes;
    use PassKitTrait;

    public function findBySerialNumber($serialNumber)
    {
        return Voucher::where('uuid', '=', $serialNumber)->first();
    }

    public function getSerialNumber()
    {
        return $this->uuid;
    }


    public function getBalanceField()
    {
        return 'balance';
    }
}
