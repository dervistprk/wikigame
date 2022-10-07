<?php

$article_controller = App\Http\Controllers\frontend\ArticleController::class;
$game_controller    = App\Http\Controllers\frontend\GameController::class;
$home_controller    = App\Http\Controllers\frontend\HomeController::class;
$user_controller    = App\Http\Controllers\frontend\UserController::class;
$facebook_service   = App\Services\FacebookAuthService::class;
$github_service     = App\Services\GithubAuthService::class;
$google_service     = App\Services\GoogleAuthService::class;
$linkedin_service   = App\Services\LinkedinAuthService::class;
$twitter_service    = App\Services\TwitterAuthService::class;

return [
    'menus'  => [
        ['title' => 'Ana Sayfa', 'segment' => '', 'route' => 'home', 'icon' => 'home'],
        ['title' => 'Rastgele Oyun', 'segment' => '---', 'route' => 'random-game', 'icon' => 'random'],
        ['title' => 'Geliştiriciler', 'segment' => 'gelistiriciler', 'route' => 'developers', 'icon' => 'code'],
        ['title' => 'Dağıtıcılar', 'segment' => 'dagiticilar', 'route' => 'publishers', 'icon' => 'newspaper'],
        ['title' => 'Makaleler', 'segment' => 'makaleler', 'route' => 'articles', 'icon' => 'book-open'],
        ['title' => 'Hakkında', 'segment' => 'hakkinda', 'route' => 'about', 'icon' => 'book'],
    ],
    'routes' => [
        'home'               => ['method' => 'get', 'uri' => '/', 'controller' => $home_controller, 'function' => 'home', 'middleware' => 'maintenance'],
        'all-games'          => ['method' => 'get', 'uri' => 'tum-oyunlar', 'controller' => $game_controller, 'function' => 'list', 'middleware' => 'maintenance'],
        'random-game'        => ['method' => 'get', 'uri' => 'rastgele-oyun', 'controller' => $home_controller, 'function' => 'randomGame', 'middleware' => 'maintenance'],
        'game'               => ['method' => 'get', 'uri' => 'oyun/{slug}', 'controller' => $game_controller, 'function' => 'gameDetails', 'middleware' => 'maintenance'],
        'developers'         => ['method' => 'get', 'uri' => 'gelistiriciler', 'controller' => $game_controller, 'function' => 'developers', 'middleware' => 'maintenance'],
        'developer'          => ['method' => 'get', 'uri' => 'gelistirici/{id}', 'controller' => $game_controller, 'function' => 'developer', 'middleware' => 'maintenance'],
        'publishers'         => ['method' => 'get', 'uri' => 'dagiticilar', 'controller' => $game_controller, 'function' => 'publishers', 'middleware' => 'maintenance'],
        'publisher'          => ['method' => 'get', 'uri' => 'dagitici/{id}', 'controller' => $game_controller, 'function' => 'publisher', 'middleware' => 'maintenance'],
        'about'              => ['method' => 'get', 'uri' => 'hakkinda', 'controller' => $home_controller, 'function' => 'about', 'middleware' => 'maintenance'],
        'category'           => ['method' => 'get', 'uri' => 'kategori/{id}', 'controller' => $home_controller, 'function' => 'category', 'middleware' => 'maintenance'],
        'articles'           => ['method' => 'get', 'uri' => 'makaleler', 'controller' => $article_controller, 'function' => 'articles', 'middleware' => 'maintenance'],
        'article'            => ['method' => 'get', 'uri' => 'makale/{id}', 'controller' => $article_controller, 'function' => 'article', 'middleware' => 'maintenance'],
        'search'             => ['method' => 'get', 'uri' => 'arama', 'controller' => $home_controller, 'function' => 'search', 'middleware' => ['maintenance', 'remove_token']],
        'autocompleteSearch' => ['method' => 'get', 'uri' => 'oto-arama', 'controller' => $home_controller, 'function' => 'autoComplete', 'middleware' => 'maintenance'],
        'register-form'      => ['method' => 'get', 'uri' => 'uye-ol', 'controller' => $user_controller, 'function' => 'registerForm', 'middleware' => ['maintenance', 'prevent_if_login']],
        'register-post'      => ['method' => 'post', 'uri' => 'uye-ol', 'controller' => $user_controller, 'function' => 'registerPost', 'middleware' => ['maintenance', 'prevent_if_login']],
        'login-form'         => ['method' => 'get', 'uri' => 'giris', 'controller' => $user_controller, 'function' => 'loginForm', 'middleware' => ['maintenance', 'prevent_if_login']],
        'login-post'         => ['method' => 'post', 'uri' => 'giris', 'controller' => $user_controller, 'function' => 'loginPost', 'middleware' => ['maintenance', 'prevent_if_login']],

        'redirect-google'   => ['method' => 'get', 'uri' => 'redirect-google', 'controller' => $google_service, 'function' => 'redirectToGoogle', 'middleware' => ['maintenance', 'prevent_if_login']],
        'handle-google'     => ['method' => 'get', 'uri' => 'callback-google', 'controller' => $google_service, 'function' => 'handleGoogleCallback', 'middleware' => ['maintenance', 'prevent_if_login']],
        'redirect-facebook' => ['method' => 'get', 'uri' => 'redirect-facebook', 'controller' => $facebook_service, 'function' => 'redirectToFacebook', 'middleware' => ['maintenance', 'prevent_if_login']],
        'handle-facebook'   => ['method' => 'post', 'uri' => 'callback-facebook', 'controller' => $facebook_service, 'function' => 'handleFacebookCallback', 'middleware' => ['maintenance', 'prevent_if_login']],
        'redirect-github'   => ['method' => 'get', 'uri' => 'redirect-github', 'controller' => $github_service, 'function' => 'redirectToGithub', 'middleware' => ['maintenance', 'prevent_if_login']],
        'handle-github'     => ['method' => 'get', 'uri' => 'callback-github', 'controller' => $github_service, 'function' => 'handleGithubCallback', 'middleware' => ['maintenance', 'prevent_if_login']],
        'redirect-linkedin' => ['method' => 'get', 'uri' => 'redirect-linkedin', 'controller' => $linkedin_service, 'function' => 'redirectToLinkedin', 'middleware' => ['maintenance', 'prevent_if_login']],
        'handle-linkedin'   => ['method' => 'get', 'uri' => 'callback-linkedin', 'controller' => $linkedin_service, 'function' => 'handleLinkedinCallback', 'middleware' => ['maintenance', 'prevent_if_login']],
        'redirect-twitter'  => ['method' => 'get', 'uri' => 'redirect-twitter', 'controller' => $twitter_service, 'function' => 'redirectToTwitter', 'middleware' => ['maintenance', 'prevent_if_login']],
        'handle-twitter'    => ['method' => 'post', 'uri' => 'callback-twitter', 'controller' => $twitter_service, 'function' => 'handleTwitterCallback', 'middleware' => ['maintenance', 'prevent_if_login']],

        'user-profile'            => ['method' => 'get', 'uri' => 'profil', 'controller' => $user_controller, 'function' => 'userProfile', 'middleware' => ['maintenance', 'is_login_user', 'is_banned', 'is_verify_email']],
        'update-profile'          => ['method' => 'any', 'uri' => 'profil-guncelle', 'controller' => $user_controller, 'function' => 'updateProfile', 'middleware' => ['maintenance', 'is_login_user', 'is_verify_email']],
        'user-logout'             => ['method' => 'get', 'uri' => 'cikis', 'controller' => $user_controller, 'function' => 'logout', 'middleware' => ['maintenance', 'is_login_user', 'is_verify_email']],
        'resend-verification'     => ['method' => 'any', 'uri' => 'mail-gonder', 'controller' => $user_controller, 'function' => 'resendVerification', 'middleware' => ['maintenance', 'prevent_if_login']],
        'user-verify'             => ['method' => 'get', 'uri' => 'profil/dogrula/{user_id}/{token}', 'controller' => $user_controller, 'function' => 'verifyAccount', 'middleware' => ['maintenance', 'is_banned_not_login', 'prevent_if_login']],
        'user-make-game-comment'  => ['method' => 'post', 'uri' => 'yorum-yap/{commentable_id}', 'controller' => $user_controller, 'function' => 'makeGameComment', 'middleware' => ['maintenance', 'is_banned']],
        'user-edit-game-comment'  => ['method' => 'post', 'uri' => 'yorum-duzenle/{commentable_id}/{comment_id}', 'controller' => $user_controller, 'function' => 'editGameComment', 'middleware' => ['maintenance', 'is_banned']],
        'user-reply-game-comment' => ['method' => 'post', 'uri' => 'yorum-yanitla/{commentable_id}/{parent_comment_id}', 'controller' => $user_controller, 'function' => 'replyGameComment', 'middleware' => ['maintenance', 'is_banned']],
    ]
];