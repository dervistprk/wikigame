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
        $this->comment       = $comment;
        $this->content       = $content;
        $this->disliked_user = $disliked_user;
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
        $this->content->name ? $url = url('/oyun/' . $this->content->slug) : $url = url('/makale/' . $this->content->slug);
        return (new MailMessage())
            ->error()
            ->subject(__('Yorum Beğenilmedi'))
            ->greeting(trans('messages.mail_greeting_message', ['name' => $this->comment->user->name, 'surname' => $this->comment->user->surname]))
            ->line(__('Yapmış olduğunuz bir yorum beğenilmedi.'))
            ->line(new HtmlString('<h4>' . __('Yorum İçeriği') . '</h4>'))
            ->line(new HtmlString('<div style="background: #F8F8FFFF; padding: 10px; border-radius: 12px">' . $this->comment->body . '</div>'))
            ->line(
                new HtmlString(
                    trans('messages.comment_dislike_user',
                        [
                            'name'      => $this->disliked_user->name,
                            'surname'   => $this->disliked_user->surname,
                            'user_name' => $this->disliked_user->user_name
                        ]
                    )
                )
            )
            ->action(__('İçeriğe gitmek için tıklayın'), $url)
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
