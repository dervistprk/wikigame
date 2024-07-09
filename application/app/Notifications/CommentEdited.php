<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class CommentEdited extends Notification
{
    use Queueable;

    protected $comment;
    protected $content;
    protected $comment_old_body;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment, $content, $comment_old_body)
    {
        $this->comment          = $comment;
        $this->content          = $content;
        $this->comment_old_body = $comment_old_body;
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
    public function toMail($notifiable): MailMessage
    {
        $this->content->name ? $url = url('/oyun/' . $this->content->slug) : $url = url('/makale/' . $this->content->slug);
        return (new MailMessage())
            ->subject(__('Yorum Düzenlendi'))
            ->greeting(trans('messages.mail_greeting_message', ['name' => $this->comment->user->name, 'surname' => $this->comment->user->surname]))
            ->line(__('Yapmış olduğunuz yorum yönetici tarafından düzenlenmiştir.'))
            ->line(new HtmlString('<h4>' . __('Eski Yorum İçeriği') . '</h4>'))
            ->line(new HtmlString('<div style="background: #F8F8FFFF; padding: 10px; border-radius: 12px">' . $this->comment_old_body . '</div>'))
            ->line(new HtmlString('<h4>' . __('Yeni Yorum İçeriği') . '</h4>'))
            ->line(new HtmlString('<div style="background: #F8F8FFFF; padding: 10px; border-radius: 12px">' . $this->comment->body . '</div>'))
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
