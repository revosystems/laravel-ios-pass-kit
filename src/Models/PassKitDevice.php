<?php

namespace RevoSystems\iOSPassKit\Models;

use App\Models\Modules\GiftCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RevoSystems\iOSPassKit\Traits\PassKitTrait;

class PassKitDevice extends Model
{
    protected $guarded  = [];

    public function getTable()
    {
        return config('passKit.devices_table', 'devices');
    }
}
