<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class CommentLiked extends Notification
{
    use Queueable;

    protected $comment;
    protected $content;
    protected $liked_user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment, $content, $liked_user)
    {
        $this->comment    = $comment;
        $this->content    = $content;
        $this->liked_user = $liked_user;
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
            ->success()
            ->subject(__('Yorum Beğenildi'))
            ->greeting(trans('messages.mail_greeting_message', ['name' => $this->comment->user->name, 'surname' => $this->comment->user->surname]))
            ->line(__('Yapmış olduğunuz yoruma beğeni geldi.'))
            ->line(new HtmlString('<h4>' . __('Yorum İçeriği') . '</h4>'))
            ->line(new HtmlString('<div style="background: #F8F8FFFF; padding: 10px; border-radius: 12px">' . $this->comment->body . '</div>'))
            ->line(
                new HtmlString(
                    trans(
                        'messages.comment_dislike_user',
                        [
                            'name'      => $this->liked_user->name,
                            'surname'   => $this->liked_user->surname,
                            'user_name' => $this->liked_user->user_name
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
