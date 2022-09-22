<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentVerified extends Notification
{
    use Queueable;

    protected $comment;
    protected $content;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment, $content)
    {
        $this->comment = $comment;
        $this->content = $content;
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
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $this->content->name ? $url = url('/oyun/' . $this->content->slug) : $url = url('/makale/' . $this->content->slug);

        if ($this->comment->is_verified == 0) {
            return (new MailMessage())
                ->error()
                ->subject('Yorum Yayınlanmadı')
                ->greeting('Merhaba.')
                ->line('Yapmış olduğunuz yorum kurallarımız gereği yayından kaldırılmıştır.')
                ->action('İçeriğe gitmek için tıklayın', $url)
                ->line('Wikigame ekibi olarak teşekkür ederiz.');
        }

        return (new MailMessage())
            ->subject('Yorum Yayınlandı')
            ->greeting('Merhaba.')
            ->line('Yapmış olduğunuz yorum yayına alınmıştır.')
            ->action('İçeriğe gitmek için tıklayın', $url)
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
