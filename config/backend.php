<?php

$admin_controller        = App\Http\Controllers\backend\AdminController::class;
$backend_game_controller = App\Http\Controllers\backend\GameController::class;
$platform_controller     = App\Http\Controllers\backend\PlatformController::class;
$genre_controller        = App\Http\Controllers\backend\GenreController::class;
$category_controller     = App\Http\Controllers\backend\CategoryController::class;
$developer_controller    = App\Http\Controllers\backend\DeveloperController::class;
$publisher_controller    = App\Http\Controllers\backend\PublisherController::class;
$article_controller      = App\Http\Controllers\backend\ArticleController::class;
$auth_controller         = App\Http\Controllers\backend\AuthController::class;
$setting_controller      = App\Http\Controllers\backend\SettingController::class;

return [
    'menus'    => [
        ['title' => 'Yönetim Paneli', 'segment' => 'yonetim', 'route' => 'dashboard', 'icon' => 'tachometer-alt'],
        ['title' => 'Kategoriler', 'segment' => 'kategoriler', 'route' => 'categories', 'icon' => 'bookmark'],
        ['title' => 'Oyunlar', 'segment' => 'oyunlar', 'route' => 'games', 'icon' => 'gamepad'],
        ['title' => 'Geliştiriciler', 'segment' => 'gelistiriciler', 'route' => 'developers', 'icon' => 'calculator'],
        ['title' => 'Dağıtıcılar', 'segment' => 'dagiticilar', 'route' => 'publishers', 'icon' => 'newspaper'],
        ['title' => 'Türler', 'segment' => 'turler', 'route' => 'genres', 'icon' => 'list'],
        ['title' => 'Platformlar', 'segment' => 'platformlar', 'route' => 'platforms', 'icon' => 'laptop'],
        ['title' => 'Makaleler', 'segment' => 'makaleler', 'route' => 'articles', 'icon' => 'book-open'],
        ['title' => 'Ayarlar', 'segment' => 'ayarlar', 'route' => 'settings', 'icon' => 'cog'],
    ],
    'routes'   => [
        //dashboard and settings
        'dashboard'                => ['method' => 'get', 'uri' => 'yonetim', 'controller' => $admin_controller, 'function' => 'dashboard', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'profile'                  => ['method' => 'get', 'uri' => 'profil', 'controller' => $admin_controller, 'function' => 'admin', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'profile-post'             => ['method' => 'post', 'uri' => 'profil', 'controller' => $admin_controller, 'function' => 'adminPost', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'settings'                 => ['method' => 'get', 'uri' => 'ayarlar', 'controller' => $setting_controller, 'function' => 'settings', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'settings-update'          => ['method' => 'post', 'uri' => 'ayarlar', 'controller' => $setting_controller, 'function' => 'settingsUpdate', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],

        //games
        'games'                    => ['method' => 'get', 'uri' => 'oyunlar', 'controller' => $backend_game_controller, 'function' => 'index', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'create-game'              => ['method' => 'get', 'uri' => 'oyun-ekle', 'controller' => $backend_game_controller, 'function' => 'create', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'create-game-post'         => ['method' => 'post', 'uri' => 'oyun-ekle', 'controller' => $backend_game_controller, 'function' => 'store', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'edit-game'                => ['method' => 'get', 'uri' => 'oyun-duzenle/{id}', 'controller' => $backend_game_controller, 'function' => 'edit', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'edit-game-post'           => ['method' => 'post', 'uri' => 'oyun-duzenle/{id}', 'controller' => $backend_game_controller, 'function' => 'update', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'delete-game'              => ['method' => 'get', 'uri' => 'oyun-sil/{id}', 'controller' => $backend_game_controller, 'function' => 'destroy', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'switch-game-status'       => ['method' => 'post', 'uri' => 'oyun-durumu', 'controller' => $backend_game_controller, 'function' => 'switchStatus', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'delete-single-game-image' => ['method' => 'post', 'uri' => 'resim-sil', 'controller' => $backend_game_controller, 'function' => 'deleteSingleImage', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'delete-game-video'        => ['method' => 'post', 'uri' => 'video-sil', 'controller' => $backend_game_controller, 'function' => 'deleteGameVideo', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],

        //platforms
        'platforms'                => ['method' => 'get', 'uri' => 'platformlar', 'controller' => $platform_controller, 'function' => 'index', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'create-platform'          => ['method' => 'get', 'uri' => 'platform-ekle', 'controller' => $platform_controller, 'function' => 'create', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'create-platform-post'     => ['method' => 'post', 'uri' => 'platform-ekle', 'controller' => $platform_controller, 'function' => 'store', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'edit-platform'            => ['method' => 'get', 'uri' => 'platform-duzenle/{id}', 'controller' => $platform_controller, 'function' => 'edit', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'edit-platform-post'       => ['method' => 'post', 'uri' => 'platform-duzenle/{id}', 'controller' => $platform_controller, 'function' => 'update', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'delete-platform'          => ['method' => 'get', 'uri' => 'platform-sil/{id}', 'controller' => $platform_controller, 'function' => 'destroy', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'switch-platform-status'   => ['method' => 'post', 'uri' => 'platform-durumu', 'controller' => $platform_controller, 'function' => 'switchStatus', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],

        //genres
        'genres'                   => ['method' => 'get', 'uri' => 'turler', 'controller' => $genre_controller, 'function' => 'index', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'create-genre'             => ['method' => 'get', 'uri' => 'tur-ekle', 'controller' => $genre_controller, 'function' => 'create', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'create-genre-post'        => ['method' => 'post', 'uri' => 'tur-ekle', 'controller' => $genre_controller, 'function' => 'store', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'edit-genre'               => ['method' => 'get', 'uri' => 'tur-duzenle/{id}', 'controller' => $genre_controller, 'function' => 'edit', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'edit-genre-post'          => ['method' => 'post', 'uri' => 'tur-duzenle/{id}', 'controller' => $genre_controller, 'function' => 'update', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'delete-genre'             => ['method' => 'get', 'uri' => 'tur-sil/{id}', 'controller' => $genre_controller, 'function' => 'destroy', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'switch-genre-status'      => ['method' => 'post', 'uri' => 'tur-durumu', 'controller' => $genre_controller, 'function' => 'switchStatus', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],

        //categories
        'categories'               => ['method' => 'get', 'uri' => 'kategoriler', 'controller' => $category_controller, 'function' => 'index', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'create-category'          => ['method' => 'get', 'uri' => 'kategori-ekle', 'controller' => $category_controller, 'function' => 'create', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'create-category-post'     => ['method' => 'post', 'uri' => 'kategori-ekle', 'controller' => $category_controller, 'function' => 'store', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'edit-category'            => ['method' => 'get', 'uri' => 'kategori-duzenle/{id}', 'controller' => $category_controller, 'function' => 'edit', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'edit-category-post'       => ['method' => 'post', 'uri' => 'kategori-duzenle/{id}', 'controller' => $category_controller, 'function' => 'update', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'delete-category'          => ['method' => 'get', 'uri' => 'kategori-sil/{id}', 'controller' => $category_controller, 'function' => 'destroy', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'switch-category-status'   => ['method' => 'post', 'uri' => 'kategori-durumu', 'controller' => $category_controller, 'function' => 'switchStatus', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],

        //developers
        'developers'               => ['method' => 'get', 'uri' => 'gelistiriciler', 'controller' => $developer_controller, 'function' => 'index', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'create-developer'         => ['method' => 'get', 'uri' => 'gelistirici-ekle', 'controller' => $developer_controller, 'function' => 'create', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'create-developer-post'    => ['method' => 'post', 'uri' => 'gelistirici-ekle', 'controller' => $developer_controller, 'function' => 'store', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'edit-developer'           => ['method' => 'get', 'uri' => 'gelistirici-duzenle/{id}', 'controller' => $developer_controller, 'function' => 'edit', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'edit-developer-post'      => ['method' => 'post', 'uri' => 'gelistirici-duzenle/{id}', 'controller' => $developer_controller, 'function' => 'update', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'delete-developer'         => ['method' => 'get', 'uri' => 'gelistirici-sil/{id}', 'controller' => $developer_controller, 'function' => 'destroy', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'switch-developer-status'  => ['method' => 'post', 'uri' => 'gelistirici-durumu', 'controller' => $developer_controller, 'function' => 'switchStatus', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],

        //publishers
        'publishers'               => ['method' => 'get', 'uri' => 'dagiticilar', 'controller' => $publisher_controller, 'function' => 'index', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'create-publisher'         => ['method' => 'get', 'uri' => 'dagitici-ekle', 'controller' => $publisher_controller, 'function' => 'create', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'create-publisher-post'    => ['method' => 'post', 'uri' => 'dagitici-ekle', 'controller' => $publisher_controller, 'function' => 'store', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'edit-publisher'           => ['method' => 'get', 'uri' => 'dagitici-duzenle/{id}', 'controller' => $publisher_controller, 'function' => 'edit', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'edit-publisher-post'      => ['method' => 'post', 'uri' => 'dagitici-duzenle/{id}', 'controller' => $publisher_controller, 'function' => 'update', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'delete-publisher'         => ['method' => 'get', 'uri' => 'dagitici-sil/{id}', 'controller' => $publisher_controller, 'function' => 'destroy', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'switch-publisher-status'  => ['method' => 'post', 'uri' => 'dagitici-durumu', 'controller' => $publisher_controller, 'function' => 'switchStatus', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],

        //articles
        'articles'                 => ['method' => 'get', 'uri' => 'makaleler', 'controller' => $article_controller, 'function' => 'index', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'create-article'           => ['method' => 'get', 'uri' => 'makale-ekle', 'controller' => $article_controller, 'function' => 'create', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'create-article-post'      => ['method' => 'post', 'uri' => 'makale-ekle', 'controller' => $article_controller, 'function' => 'store', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'edit-article'             => ['method' => 'get', 'uri' => 'makale-duzenle/{id}', 'controller' => $article_controller, 'function' => 'edit', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'edit-article-post'        => ['method' => 'post', 'uri' => 'makale-duzenle/{id}', 'controller' => $article_controller, 'function' => 'update', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'delete-article'           => ['method' => 'get', 'uri' => 'makale-sil/{id}', 'controller' => $article_controller, 'function' => 'destroy', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'switch-article-status'    => ['method' => 'post', 'uri' => 'makale-durumu', 'controller' => $article_controller, 'function' => 'switchStatus', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],

        //logout
        'logout'                   => ['method' => 'get', 'uri' => 'cikis', 'controller' => $auth_controller, 'function' => 'logout', 'middleware' => ['white_list', 'isAdmin'], 'group_name' => 'admin.', 'prefix' => 'admin'],

        //login
        'login'                    => ['method' => 'get', 'uri' => 'giris', 'controller' => $auth_controller, 'function' => 'login', 'middleware' => ['white_list', 'is_login_admin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
        'login-post'               => ['method' => 'post', 'uri' => 'giris', 'controller' => $auth_controller, 'function' => 'loginPost', 'middleware' => ['white_list', 'is_login_admin'], 'group_name' => 'admin.', 'prefix' => 'admin'],
    ],
    'per_page' => [10, 20, 30, 40, 50]
];