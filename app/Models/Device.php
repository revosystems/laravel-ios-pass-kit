<?php

namespace RevoSystems\Demo\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public function giftCards()
    {
        return $this->morphedByMany(GiftCard::class, 'taggable');
    }

    public function vouchers()
    {
        return $this->morphedByMany(Voucher::class, 'taggable');
    }
}
