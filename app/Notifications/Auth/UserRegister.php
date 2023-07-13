<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRegister extends Notification implements ShouldQueue
{
    use Queueable;

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
            ->success()
            ->subject(__('Confirmation of your account registration'))
            ->greeting(__('Welcome') . ' ' . $notifiable->name . ',')
            ->line(__('We confirm that you have successfully registered on
            our website, you can access using the following link') . ':')
            ->action(__('Access the site'), url('/'))
            ->line(__('If you have not registered yourself,
            someone has used this email address, we recommend that you contact the administrators') . '.');
    }
}
