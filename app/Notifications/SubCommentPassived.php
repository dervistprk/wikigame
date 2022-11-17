<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SubCommentPassived extends Notification
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
    public function toMail($notifiable)
    {
        $this->content->name ? $url = url('/oyun/' . $this->content->slug) : $url = url('/makale/' . $this->content->slug);
        return (new MailMessage())
            ->error()
            ->subject(__('Yorum Cevabı Yayından Kaldırıldı'))
            ->greeting(trans('messages.mail_greeting_message', ['name' => $this->comment->user->name, 'surname' => $this->comment->user->surname]))
            ->line(__('Cevap vermiş olduğunuz bir yorum kaldırıldığı için cevabınız da kaldırıldı.'))
            ->line(new HtmlString('<h4>' . __('Yorum İçeriği') . '</h4>'))
            ->line(new HtmlString('<div style="background: #F8F8FFFF; padding: 10px; border-radius: 12px">' . $this->comment->body . '</div>'))
            ->line(__('Rahatsız olduğunuz herhangi bir durum olduğunda bizimle iletişime geçebilirsiniz.'))
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
