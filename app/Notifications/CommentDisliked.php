<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class CommentDisliked extends Notification
{
    use Queueable;

    protected $comment;
    protected $content;
    protected $disliked_user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment, $content, $disliked_user)
    {
        $this->comment    = $comment;
        $this->content    = $content;
        $this->disliked_user = $disliked_user;
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
        $this->content->name ? $url = url('/oyun/' . $this->content->slug) : $url = url('/makale/' . $this->content->slug);
        return (new MailMessage())
            ->error()
            ->subject('Yorum Beğenilmedi')
            ->greeting('Merhaba ' . $this->comment->user->name . ' ' . $this->comment->user->surname)
            ->line('Yapmış olduğunuz bir yorum beğenilmemiştir.')
            ->line(new HtmlString('<h4>Yorum İçeriği</h4>'))
            ->line(new HtmlString('<div style="background: #F8F8FFFF; padding: 10px; border-radius: 12px">' . $this->comment->body . '</div>'))
            ->line(new HtmlString('Yorumu beğenmeyen kullanıcımız: <strong>'. $this->disliked_user->name . ' ' . $this->disliked_user->surname .' ['. $this->disliked_user->user_name . ']</strong>'))
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
