<?php

namespace App\Notifications\Repair;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioSmsMessage;

class RepairOrderStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;
    private $status;
    private $configs;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($configs, $status)
    {
        $this->configs = $configs;
        $this->status = $status;
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
            ->subject('[' . $this->status . '] ' . __('Your repair status updated'))
            ->greeting(__('Hi') . ' ' . $notifiable->name . ',')
            ->line(__('We have updated your repair status.'))
            ->line(__('You can view the repair order details from this link') . ':')
            ->action(
                __('Track repair status'),
                url('/track/' . $notifiable->tracking . '?stamp=' . $notifiable->uuid)
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
            ->content(__('We have updated your repair status') . ' ( ID #' . $notifiable->tracking . ') ' . config('app.name'));
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content(__('We have updated your repair status') . ' ( ID #' . $notifiable->tracking . ') ' . config('app.name'));
    }
}
