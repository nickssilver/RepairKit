<?php

namespace App\Notifications\Repair;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NewRepairOrder extends Notification implements ShouldQueue
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
        $this->configs = $configs;
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
            ->subject(__('Your repair order') . ' # ' . $notifiable->tracking)
            ->greeting(__('Hi') . ' ' . $notifiable->name . ',')
            ->line(__('We have received your repair request and we will try to update you as soon as possible') . '.')
            ->line(__('You can view the repair order details from this link') . ':')
            ->action(__('Print or download'), url('/print/repair-order/' . $notifiable->uuid));
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @return NexmoMessage  The nexmo message.
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage())
            ->content(__('Hello! Your Order has been successfully received') . ' ( TR #' . $notifiable->tracking . ') ' . config('app.name'));
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content(__('Hello! Your Order has been successfully received') . ' ( TR #' . $notifiable->tracking . ') ' . config('app.name'));
    }
}
