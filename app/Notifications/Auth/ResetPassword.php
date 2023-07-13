<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;

    /**
     * Constructs a new instance.
     *
     * @param      <type>  $token  The token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->email ? ['mail'] : null;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(__('Recover account'))
            ->greeting(__('Hi') . ' ' . $notifiable->name . ',')
            ->line(__('You are receiving this email because we
            received a password reset request for your account') . '.')
            ->action(
                __('Reset password'),
                url('/auth/reset/' . $this->token) . '?email=' . urlencode($notifiable->email)
            )
            ->line(__('If you did not request a password reset, no further action is required') . '.');
    }
}
