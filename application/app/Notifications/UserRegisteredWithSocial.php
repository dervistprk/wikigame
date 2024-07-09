<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UserRegisteredWithSocial extends Notification
{
    use Queueable;

    protected $user;
    protected $password;
    protected $social;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $password, $social)
    {
        $this->user     = $user;
        $this->password = $password;
        $this->social   = $social;
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
            ->subject(__('WikiGame Üyelik Bilgileri'))
            ->greeting(trans('messages.mail_greeting_message', ['name' => $this->user->name, 'surname' => $this->user->surname]))
            ->line(__('WikiGame\'e hoşgeldiniz. Sizi aramızda görmekten mutluluk duyuyoruz.'))
            ->line(new HtmlString(trans('messages.registered_with_social_message', ['social' => $this->social])))
            ->line(__('Şifrenizi değiştirmenizi şiddetle tavsiye ederiz.'))
            ->line(new HtmlString(trans('messages.how_to_change_password_mail_line')))
            ->line(new HtmlString(trans('messages.user_password_via_mail', ['password' => $this->password])))
            ->action(__('Profilim'), route('user-profile'))
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
