<?php

namespace RevoSystems\iOSPassKit\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use RevoSystems\Demo\Models\GiftCard;
use RevoSystems\iOSPassKit\Services\PassKitGenerator;
use RevoSystems\iOSPassKit\Tests\TestBusinessSetupTrait;
use RevoSystems\iOSPassKit\Tests\TestCase;

class PassKitGeneratorTest extends TestCase
{
    use RefreshDatabase;
    use TestBusinessSetupTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpBusiness();
        $this->actingAs($this->user);
    }

    /** @test */
    public function can_get_business_pass()
    {
        $pass         = (new GiftCard);
        $businessPass = $this->callObjectMethod(PassKitGenerator::make($pass), 'getBusinessPass');

        $this->assertEquals([
            'serialNumber' => '1234',
            'locations'    => [
                ['latitude' => 41.673385, 'longitude' => 1.764578, 'relevantText' => 'Benet home is near you.']
            ],
            'barcode'          => ['message' => '1234', 'format' => 'PKBarcodeFormatQR', 'messageEncoding' => 'iso-8859-1'],
            'organizationName' => 'REVO',
            'description'      => 'Gift Card',
            'logoText'         => 'Gift Card',
            'backgroundColor'  => '#3B312F',
            'foregroundColor'  => '#F2653A',
            'labelColor'       => '#F2653A',
            'storeCard'        => [
                'primaryFields' => [
                    ['label' => 'Saldo']
                ],
                'backFields' => [
                    ['key' => 'giftcard-code', 'label' => 'Gift Card', 'value' => '1234'],
                    ['key' => 'website', 'label' => 'Check our website','value' => 'http =>//www.example.com/track-bags/XYZ123']
                ]
            ]
        ], $businessPass);
    }

    /** @test */
    public function can_get_base_pass()
    {
        $pass         = (new GiftCard);

        $basePass = $this->callObjectMethod(PassKitGenerator::make($pass), 'getBasePass');

        $this->assertEquals([
            'formatVersion'      => 1,
            'passTypeIdentifier' => 'pass.works.revointouch.giftcard',
            'teamIdentifier'     => 'TJELNB34R9',
            'barcode'            => ['format' => 'PKBarcodeFormatQR', 'messageEncoding' => 'iso-8859-1',],
            'storeCard'          => [
                'primaryFields' => [
                    ['key' => 'balance', 'currencyCode' => 'EUR',],
                ],
                'backFields' => [],
            ],
        ], $basePass);
    }

    /** @test */
    public function can_merge_business_pass_into_base_pass()
    {
        $pass         = (new GiftCard);
        $businessPass = $this->callObjectMethod(PassKitGenerator::make($pass), 'getBusinessPass');
        $basePass     = $this->callObjectMethod(PassKitGenerator::make($pass), 'getBasePass');

        $mergedPass = $this->callObjectMethod(PassKitGenerator::make($pass), 'mergePass', [$pass, $basePass, $businessPass]);

        $this->assertEquals([
            'formatVersion'      => 1,
            'passTypeIdentifier' => 'pass.works.revointouch.giftcard',
            'teamIdentifier'     => 'TJELNB34R9',
            'barcode'            => ['format' => 'PKBarcodeFormatQR', 'messageEncoding' => 'iso-8859-1', 'message' => '1234'],
            'storeCard'          => [
                'primaryFields' => [
                    ['key' => 'balance', 'currencyCode' => 'EUR', 'label' => 'Saldo', 'value' => 0.0],
                ],
                'backFields' => [
                    ['key' => 'giftcard-code', 'label' => 'Gift Card', 'value' => '1234'],
                    ['key' => 'website', 'label' => 'Check our website', 'value' => 'http =>//www.example.com/track-bags/XYZ123'],
                ],
            ],
            'serialNumber'        => null,
            'webServiceURL'       => 'http://localhost/api/passKit/revo',
            'authenticationToken' => 'demo-passKit-token',
            'locations'           => [
                ['latitude' => 41.673385, 'longitude' => 1.764578, 'relevantText' => 'Benet home is near you.'],
            ],
            'organizationName' => 'REVO',
            'description'      => 'Gift Card',
            'logoText'         => 'Gift Card',
            'backgroundColor'  => '#3B312F',
            'foregroundColor'  => '#F2653A',
            'labelColor'       => '#F2653A',
        ], $mergedPass);
    }
}
