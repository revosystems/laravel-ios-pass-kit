<?php

namespace RevoSystems\iOSPassKit\Models;

use App\Models\Modules\GiftCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PassKitRegistration extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    public function devices()
    {
        return $this->hasMany(PassKitDevice::class);
    }
}