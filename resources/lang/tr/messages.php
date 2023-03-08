<?php

return [
    'min_comment_char_limit'           => 'Lütfen en az <strong>30</strong> karakter uzunluğunda bir yorum giriniz.',
    'min_about_char_limit'             => 'Lütfen <strong>hakkımda</strong> kısmını en az <strong>30</strong> karakter uzunluğunda giriniz.',
    'register_or_login_to_comment'     => 'Yorum yapabilmek için lütfen <a href="/giris" class="register-login-link text-decoration-none">giriş yap</a> veya <a href="/uye-ol" class="register-login-link text-decoration-none">üye ol</a>.',
    'user_agreement_verify_text'       => '<a href="" class="game-detail-links text-decoration-none" data-bs-toggle="modal" data-bs-target="#user-agreement-modal">Kullanıcı sözleşmesini</a> okudum ve kabul ediyorum.',
    'user_agreement_top_text'          => 'Lütfen aşağıda belirtilen kuralları dikkatle okuyunuz.<br>Kuralları okumamanızdan kaynaklı bir sorunda WikiGame herhangi bir sorumluluk kabul etmemektedir.',
    'user_agreement_bottom_text'       => 'Yukarıda yazılı kurallardan herhangi birine uymadığım takdirde siteden <span class="text-warning">geçici</span> veya <span class="text-danger">kalıcı</span> olarak yasaklanabileceğimi kabul ediyorum.',
    'welcome_message'                  => 'Hoşgeldiniz sayın :name :surname',
    'profile_panel_message'            => 'Profilim sayfasına hoşgeldiniz. Buradan profilinizle ilgili çeşitli işlemler gerçekleştirebilir, bilgilerinize göz atabilirsiniz. Alttaki butonlardan ilgili işlemleri gerçekleştirebilirsiniz.',
    'register_waiting_message'         => 'Belirtmiş olduğunuz e-posta adresine bir doğrulama postası gönderildi.<br> Doğrulama postasını almadınız mı? Tekrar göndermek için lütfen <a class="link-primary text-decoration-none" href="' . route('resend-verification') . '">tıklayın</a>.',
    'mail_greeting_message'            => 'Merhaba :name :surname',
    'comment_dislike_user'             => 'Yorumu beğenmeyen kullanıcımız <strong>:name :surname [:user_name]</strong>',
    'comment_like_user'                => 'Yorumu beğenen kullanıcımız <strong>:name :surname [:user_name]</strong>',
    'registered_with_social_message'   => '<strong>:social</strong> hizmetini kullanarak üye oldunuz. Giriş bilgileriniz aşağıda belirtilmiştir.',
    'how_to_change_password_mail_line' => '<strong>profilim->bilgilerim</strong> adımlarını takip edebilirsiniz.',
    'user_password_via_mail'           => 'Şifreniz: <strong>:password</strong>',
    'waiting_membership_approval'      => 'Üyeliğiniz henüz onaylanmadı. Üyeliğiniz ile giriş yapabilmek için lütfen e-posta hesabınıza gönderilen onay linkine tıklayın.<br>Doğrulama postasını almadınız mı? Tekrar göndermek için lütfen<a class="link-primary text-decoration-none" href="' . route('resend-verification') . '">tıklayın</a>.',
    'register_with_social_error'       => ':social ile giriş hatası',
    'register_with_social_error_msg'   => ':social ile giriş yaparken bir sorun oluştu. Lütfen tekrar deneyin.',
    'login_with_social_success'        => 'Sisteme :social servisi ile giriş yaptınız',
    'register_with_social_bio'         => ':social servisi ile kayıt yapıldı.',
    'register_with_social_success'     => 'Sisteme :social servisi ile üye oldunuz',
    'register_with_social_feedback'    => ':social servisi ile üyelik işleminiz tamamlandı. Şifreniz, mail adresinize gönderildi. Bilgilerinizi <strong><a href="' . route('update-profile') . '" class="link-primary text-decoration-none">Profil Bilgilerimi Güncelle</a></strong> sayfasından değiştirebilirsiniz.',
    'resend_verification_mail_info'    => 'Bu sayfadan yalnızca <b>onaylanmamış</b> üyelikler için yeniden doğrulama e-posta gönderme işlemi yapabilirsiniz.'
];
