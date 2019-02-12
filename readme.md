#Laravel iOS Wallet

## Description

## Installation

`composer require revosystems/laravel-ios-pass-kit`

### Config
```
return [
    'routePrefix'           => 'api/passKit',
    'passKitToken'          => 'demo-passKit-token',
    'devices_table'         => 'devices',
    'userClass'             => User::class,
    'deviceClass'           => PassKitDevice::class, // Own passkit device that extends PassKitDevice and implements morphedByMany relation
    'username_field'        => 'username',           // WHEN auth()->user()-><username>
    'apn_token_field'       => 'token',
    'passesDirectory'       => public_path() . '/',
    'passTypes' => [
        'pass.works.revointouch.giftcard' => GiftCard::class,
        'pass.works.revointouch.voucher'  => Voucher::class,
    ]
];
```

### Models
Extend PassKitDevice class
```
class PassKitDevice extends \RevoSystems\iOSPassKit\Models\PassKitDevice
{
    public function giftCards()
    {
        return $this->morphedByMany(GiftCard::class, 'pass_kit_registration');
    }
    public function vouchers()
    ...
}    
```

Add PassKitTrait to any model you want to make walletable.
```
use RevoSystems\iOSPassKit\Traits\PassKitTrait;
 
 class GiftCard extends Model
 {
    use PassKitTrait;
    ...
 ```

### Migrations
Copy desired migrations from project and apply them.
There are 2 main tables:

`devices` -> iOS Devices that will be notified. It stores device token to notify apple and device library identifier

`registrations` -> Links instances that can have device registrations like vouchers/giftcards 



### Middleware
Add middleware to kernel
```
protected $routeMiddleware = [
    ...
    'passKitApiToken'       => \RevoSystems\iOSPassKit\Http\Middleware\PassKitApiToken::class,
    'passKitApiConnection'  => \RevoSystems\iOSPassKit\Http\Middleware\PassKitApiConnection::class,
]
```
### Notifications
Generate notification certificate (https://stackoverflow.com/questions/1762555/creating-pem-file-for-apns).

Export passType p12 from keychain without password and get pem file using following command:

`openssl pkcs12 -in <exported_certificate>.p12 -out pass.works.revointouch.giftcard.pem -nodes -clcerts`

Add it to your APN_CERTIFICATE conf


## Usage


## REFERENCES
https://developer.apple.com/library/archive/documentation/UserExperience/Conceptual/PassKit_PG/Updating.html

https://developer.apple.com/library/archive/documentation/PassKit/Reference/PassKit_WebService/WebService.html

https://stackoverflow.com/questions/43522289/apple-wallet-update-values-dynamically/44544813#44544813

https://stackoverflow.com/questions/45496864/apple-wallet-pass-wont-update-automatically-after-pushing-an-update

https://stackoverflow.com/questions/991758/how-to-get-pem-file-from-key-and-crt-files
