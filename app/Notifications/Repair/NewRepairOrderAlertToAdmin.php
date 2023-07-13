<?php

namespace App\Notifications\Repair;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NewRepairOrderAlertToAdmin extends Notification implements ShouldQueue
{
    use Queueable;
    private $configs, $repairOrder;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($configs, $order)
    {
        $this->configs = $configs;
        $this->repairOrder = $order;
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
            ->subject(__('New repair order') . ' # ' . $this->repairOrder->tracking)
            ->greeting(__('From') . ' ' . $this->repairOrder->name . ',')
            ->line(__('We have received your repair request') . '.')
            ->line(__('You can view the repair order details from this link') . ':')
            ->action(__('Print or download'), url('/print/repair-order/' . $this->repairOrder->uuid));
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @return NexmoMessage  The nexmo message.
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage())
            ->content(__('Hello! New Order has been successfully received') . ' ( TR #' . $this->repairOrder->tracking . ') ' . config('app.name'));
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content(__('Hello! New Order has been successfully received') . ' ( TR #' . $this->repairOrder->tracking . ') ' . config('app.name'));
    }
}
