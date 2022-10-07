<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
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
            ->subject('WikiGame Üyelik Bilgileri')
            ->greeting('Merhaba ' . $this->user->name . ' ' . $this->user->surname)
            ->line('WikiGame\'e hoşgeldiniz. Sizi aramızda görmekten mutluluk duyuyoruz.')
            ->line(new HtmlString("<strong>$this->social</strong>  hizmetini kullanarak üye oldunuz. Giriş bilgileriniz aşağıda belirtilmiştir."))
            ->line('Şifrenizi değiştirmenizi şiddetle tavsiye ederiz.')
            ->line(new HtmlString('<strong>profilim->profil bilgilerimi güncelle</strong> adımlarını takip edebilirsiniz.'))
            ->line(new HtmlString("<strong>Şifreniz: </strong> $this->password"))
            ->action('Profilim', route('user-profile'))
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
