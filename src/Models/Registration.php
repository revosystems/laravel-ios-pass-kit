<?php

namespace RevoSystems\iOSWallet\Models;

use App\Models\Modules\GiftCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}