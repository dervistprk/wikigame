<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UserBanned extends Notification
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->error()
            ->subject('Hesap Yasaklandı')
            ->greeting('Merhaba ' . $this->user->name . ' ' . $this->user->surname)
            ->line('Sitemizde bulunan hesabınız kalıcı olarak yasaklanmıştır.')
            ->line(new HtmlString('<h4>Yasaklanma Sebebi</h4>'))
            ->line(new HtmlString('<div style="background: #F8F8FFFF; padding: 10px; border-radius: 12px">' . $this->user->ban_reason . '</div>'))
            ->line('Yasaklanma kararının yanlış olduğunu düşünüyorsanız bizimle iletişime geçebilirsiniz.')
            ->line('Wikigame ekibi olarak teşekkür ederiz.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
