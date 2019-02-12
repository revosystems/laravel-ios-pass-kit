<?php

namespace RevoSystems\iOSPassKit\Tests\Unit;

use Dotenv\Dotenv;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RevoSystems\Demo\Models\Business;
use RevoSystems\Demo\Models\GiftCard;
use RevoSystems\Demo\Models\User;
use RevoSystems\iOSPassKit\Services\PassKitGenerator;
use RevoSystems\iOSPassKit\Tests\TestCase;
use RevoSystems\iOSPassKit\Tests\TestDatabaseSetupTrait;

class PassKitGeneratorTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $business;

    public function setUp()
    {
        parent::setUp();
        $this->loadLaravelMigrations();
        $this->loadEnv();
        $this->withFactories(__DIR__.'/../../database/factories');
        $this->setUpBusiness();
        $this->actingAs($this->user);
    }


    protected function setUpBusiness()
    {
        $this->user = factory(User::class)->create();
        $this->business = factory(Business::class)->create();
    }

    protected function loadEnv()
    {
        return (new Dotenv(__DIR__, "../../.env"))->load();
    }


    /** @test */
    public function can_get_business_pass()
    {
        $pass = (new GiftCard);
        $businessPass = $this->callObjectMethod(PassKitGenerator::make($pass), 'getBusinessPass');

        $this->assertEquals([
            "serialNumber" => "1234",
            "locations" => [
                ["latitude" => 41.673385, "longitude" => 1.764578, "relevantText" => "Benet home is near you."]
            ],
            "barcode" => ["message" => "1234", "format" => "PKBarcodeFormatQR", "messageEncoding" => "iso-8859-1"],
            "organizationName" => "REVO",
            "description" => "Gift Card",
            "logoText" => "Gift Card",
            "backgroundColor" => "#3B312F",
            "foregroundColor" => "#F2653A",
            "labelColor" => "#F2653A",
            "storeCard" => [
                "primaryFields" => [
                    ["label" => "Saldo"]
                ],
                "backFields" => [
                    ["key" => "giftcard-code", "label" => "Gift Card", "value" => "1234"],
                    ["key" => "website", "label" => "Check our website","value" => "http =>//www.example.com/track-bags/XYZ123"]
                ]
            ]
        ], $businessPass);
    }
}