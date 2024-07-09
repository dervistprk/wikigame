<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserConfirmation extends Notification
{
    use Queueable;

    protected $user;
    protected $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $token)
    {
        $this->user  = $user;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__('WikiGame Üyelik Doğrulama'))
            ->greeting(trans('messages.mail_greeting_message', ['name' => $this->user->name, 'surname' => $this->user->surname]))
            ->line(__('WikiGame\'e hoşgeldiniz. Sizi aramızda görmekten mutluluk duyuyoruz.'))
            ->line(__('Üyeliğinizi tamamlamak için lütfen alttaki butona tıklayınız.'))
            ->action(__('Onayla'), route('user-verify', [$this->user->id, $this->token]))
            ->line(__('Wikigame ekibi olarak teşekkür ederiz.'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
