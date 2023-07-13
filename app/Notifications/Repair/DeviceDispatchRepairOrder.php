<?php

namespace App\Notifications\Repair;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioSmsMessage;

class DeviceDispatchRepairOrder extends Notification implements ShouldQueue
{
    use Queueable;
    private $configs;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($configs)
    {
        return $this->configs = $configs;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->configs;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(__('Waiting for your device, Dispatch it') . ' # ' . $notifiable->tracking)
            ->greeting(__('Hi') . ' ' . $notifiable->name . ',')
            ->line(__('We have received your repair request and we are waiting for your device please dispatch it as soon as possible') . '.')
            ->line(__('You can view the repair order details from this link') . ':')
            ->action(__('Print dispatch card'), url('/print/repair-dispatch-info/' . $notifiable->uuid));
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @return NexmoMessage  The nexmo message.
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage())
            ->content(__('Hello! Waiting for your device, Dispatch it') . __('lets print dispatch card'), ' ', url('/print/repair-dispatch-info/' . $notifiable->uuid) . config('app.name'));
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content(__('Hello! Waiting for your device, Dispatch it') . __('lets print dispatch card'), ' ', url('/print/repair-dispatch-info/' . $notifiable->uuid) . config('app.name'));
    }
}
