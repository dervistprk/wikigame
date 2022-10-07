<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

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
                ->subject('Yorum Reddedildi')
                ->greeting('Merhaba ' . $this->comment->user->name . ' ' . $this->comment->user->surname)
                ->line('Yapmış olduğunuz yorum kurallarımız gereği reddedilmiştir. Lütfen site kurallarını dikkatli bir şekilde okuyup, yorumunuzu bu kurallar çerçevesinde yapın.')
                ->line(new HtmlString('<h4>Yorum İçeriği</h4>'))
                ->line(new HtmlString('<div style="background: #F8F8FFFF; padding: 10px; border-radius: 12px">' . $this->comment->body . '</div>'))
                ->action('İçeriğe gitmek için tıklayın', $url)
                ->line('Wikigame ekibi olarak teşekkür ederiz.');
        }

        return (new MailMessage())
            ->success()
            ->subject('Yorum Yayınlandı')
            ->greeting('Merhaba ' . $this->comment->user->name . ' ' . $this->comment->user->surname)
            ->line('Yapmış olduğunuz yorum yayına alınmıştır.')
            ->line(new HtmlString('<h4>Yorum İçeriği</h4>'))
            ->line(new HtmlString('<div style="background: #F8F8FFFF; padding: 10px; border-radius: 12px">' . $this->comment->body . '</div>'))
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
