<?php

namespace RevoSystems\iOSWallet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RevoSystems\iOSWallet\Traits\WalletTrait;

class Pass extends Model
{
    use WalletTrait;

    const WALLET_TOKEN  = "retail-1234";
    const PASS_TYPE     = "pass.works.revointouch.giftcard";
    protected $guarded  = [];

    use SoftDeletes;

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    protected function getWalletToken()
    {
        return static::WALLET_TOKEN;
    }

    protected function getSerialNumber()
    {
        return $this->serial_number;
    }

    protected function getPassType()
    {
        return static::PASS_TYPE;
    }
}
