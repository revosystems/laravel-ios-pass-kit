<?php

namespace RevoSystems\iOSWallet\Models;

use App\Models\Modules\GiftCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
//    protected $table    = config('wallet.devices_table', 'devices');
    protected $table    = 'apn_tokens';
    protected $guarded  = [];
}
