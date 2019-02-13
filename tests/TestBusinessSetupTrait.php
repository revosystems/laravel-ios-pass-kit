<?php

namespace RevoSystems\iOSPassKit\Tests;

use RevoSystems\Demo\Models\Business;
use RevoSystems\Demo\Models\User;

trait TestBusinessSetupTrait
{
    protected $user;
    protected $business;

    protected function setUpBusiness()
    {
        $this->user     = factory(User::class)->create();
        $this->business = factory(Business::class)->create();
    }
}
