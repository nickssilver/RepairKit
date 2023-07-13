<?php

namespace App\Notifications\Repair;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioSmsMessage;

class RepairOrdersAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    private $repair;
    private $orderInfo;
    private $configs;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($configs, $repairOrder)
    {
        $this->configs = $configs;
        $this->repair = $repairOrder;
        $this->orderInfo = '[' . $this->repair->tracking . '][' . $this->repair->repairPriority->name . '] ';
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
            ->subject('[ ID:' . $notifiable->id . '] ' . $this->orderInfo . __('New repair order assigned you'))
            ->greeting(__('Hi ') . ' ' . $this->repair->user->name . ',')
            ->line(__('We have assigned you repair order and try to update repair status as soon as possible') . '.')
            ->line(__('You can open this repair order in workshop from this link') . ':')
            ->action(
                __('open in workshop'),
                url('/workshop/repairable-list/' . $this->repair->uuid . '/manage')
            );
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @return NexmoMessage  The nexmo message.
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage())
            ->content(__('New repair order assigned you') . ' [ ID:' . $notifiable->id . '] ' . $this->orderInfo . ' ' . config('app.name'));
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content(__('New repair order assigned you') . ' [ ID:' . $notifiable->id . '] ' . $this->orderInfo . ' ' . config('app.name'));
    }
}
