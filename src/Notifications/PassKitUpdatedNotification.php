<?php

namespace RevoSystems\iOSPassKit\Notifications;

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
        PassKitNotificationToken::setup($this->passType);
        parent::__wakeup();
    }

    private function setupUser()
    {
        $usernameField  = config('passKit.username_field');
        $userClass      = config('passKit.userClass');
        auth()->login($userClass::where($usernameField, $this->tenant)->firstOrFail());
        createDBConnection($usernameField, true);
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
        return ApnMessage::create();
    }
}
