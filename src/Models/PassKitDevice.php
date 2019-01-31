<?php

namespace RevoSystems\iOSPassKit\Models;

use App\Models\Modules\GiftCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RevoSystems\iOSPassKit\Traits\PassKitTrait;

class PassKitDevice extends Model
{
//    protected $table    = config('passKit.devices_table', 'devices');
    protected $table    = 'apn_tokens';    // TODO: HOW TO REMOVE FROM HWEW
    protected $guarded  = [];
}
