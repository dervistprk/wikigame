<?php

return [
    'min_comment_char_limit'           => 'Please enter a comment of at least <strong>30</strong> characters.',
    'min_about_char_limit'             => 'Please enter <strong>about me</strong> at least <strong>30</strong> characters long.',
    'register_or_login_to_comment'     => 'Please <a href="/giris" class="register-login-link text-decoration-none">login</a> or <a href="/uye-ol" class="register-login-link text-decoration-none">register</a> to leave a comment.',
    'user_agreement_verify_text'       => 'I have read and accept the <a href="" class="game-detail-links text-decoration-none" data-bs-toggle="modal" data-bs-target="#user-agreement-modal">user agreement.</a>',
    'user_agreement_top_text'          => 'Please read the rules below carefully.<br>WikiGame does not accept any responsibility for a problem caused by not reading the rules.',
    'user_agreement_bottom_text'       => 'I accept that if I do not comply with any of the rules written above, I may be <span class="text-warning">temporarily</span> or <span class="text-danger">permanently</span> banned from the site.',
    'welcome_message'                  => 'Welcome :name :surname',
    'profile_panel_message'            => 'Welcome to my profile page. From here, you can perform various operations related to your profile and browse your information. You can perform the relevant operations from the buttons below.',
    'register_waiting_message'         => 'A confirmation mail has been sent to the e-mail address you specified.<br> Did not receive the verification mail? Please <a class="link-primary text-decoration-none" href="' . route('resend-verification') . '">click</a> to resend.',
    'mail_greeting_message'            => 'Hello :name :surname',
    'comment_dislike_user'             => 'Our user who disliked the comment is <strong>:name :surname [:user_name]</strong>',
    'comment_like_user'                => 'Our user who liked the comment is <strong>:name :surname [:user_name]</strong>',
    'registered_with_social_message'   => 'You signed up using the <strong>:social</strong> service. Your login information is listed below.',
    'how_to_change_password_mail_line' => 'You can follow the steps of <strong>my profile->my information</strong>.',
    'user_password_via_mail'           => 'Your password: <strong>:password</strong>',
    'waiting_membership_approval'      => 'Your membership has not been confirmed yet. In order to log in with your membership, please click on the confirmation link sent to your e-mail account.<br>Didn\'t get the verification mail? Please <a class="link-primary text-decoration-none" href="' . route('resend-verification') . '">click</a> to resend.',
    'register_with_social_error'       => ':social login error',
    'register_with_social_error_msg'   => 'There was a problem logging in with :social. Please try again.',
    'login_with_social_success'        => 'You have logged into the system with the :social service',
    'register_with_social_bio'         => 'Registered with :social service.',
    'register_with_social_success'     => 'You have become a member of the system with the :social service',
    'register_with_social_feedback'    => 'Your subscription with :social service has been completed. Your password has been sent to your e-mail address. You can change your information on the <strong><a href="' . route('update-profile') . '" class="link-primary text-decoration-none">My Information</a></strong> page.'
];