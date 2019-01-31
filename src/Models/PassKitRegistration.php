<?php

namespace RevoSystems\iOSPassKit\Models;

use App\Models\Modules\GiftCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RevoSystems\iOSPassKit\Traits\PassKitTrait;

class PassKitRegistration extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    public function devices()
    {
        return $this->hasMany(PassKitDevice::class);
    }

//    public function passes()
//    {
//        return $this->hasMany(PassKitTrait::class);
//    }
}