<?php

namespace RevoSystems\iOSPassKit\Models;

use App\Models\Modules\GiftCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PassKitDevice extends Model
{
//    protected $table    = config('passKit.devices_table', 'devices');
    protected $table    = 'apn_tokens';
    protected $guarded  = [];

    public function giftCards()
    {
        return $this->morphedByMany(GiftCard::class, 'registration');
    }
}
