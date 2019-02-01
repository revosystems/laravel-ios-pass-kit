<?php

namespace RevoSystems\iOSPassKit\Notifications;

use App\Models\Master\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Apn\ApnChannel;
use NotificationChannels\Apn\ApnMessage;

class PassKitUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $tenant;
    public $passType;
    public $serialNumber;

    /**
     * Create a new notification instance.
     *
     * @param $tenant
     * @param $passType
     * @param $serialNumber
     */
    public function __construct($tenant, $passType, $serialNumber)
    {
        $this->tenant       = $tenant;
        $this->passType     = $passType;
        $this->serialNumber = $serialNumber;
    }

    public function __wakeup()
    {
        $this->setupUser();
        parent::__wakeup();
    }

    private function setupUser()
    {
        auth()->loginUsingId(9639);
        createDBConnection('revo', true);
        return;
        $this->tenant = $this->getPropertyValue(new \ReflectionProperty(static::class, 'tenant'));
        auth()->login(User::where('tenant', $this->tenant)->firstOrFail());
        createDBConnection('tenant', true);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ApnChannel::class];
    }

    public function toApn($notifiable)
    {
        return ApnMessage::create()
//        return ApnMessage::create(null, null, [])
//            ->badge(1)
//            ->title('Hola')
//            ->body('Que tal');
        ;
    }
}
