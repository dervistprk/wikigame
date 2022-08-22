<?php

use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\ArticleController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\DeveloperController;
use App\Http\Controllers\backend\GameController;
use App\Http\Controllers\backend\PublisherController;
use App\Http\Controllers\backend\SettingController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\backend\AuthController;
use App\Http\Controllers\frontend\UserController;
use App\Services\FacebookAuthService;
use App\Services\GithubAuthService;
use App\Services\GoogleAuthService;
use App\Services\LinkedinAuthService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/**
 * Maintenance Route
 */
Route::middleware('prevent_access')->get('bakimdayiz', function(){
    return view('frontend.errors.maintenance');
});

/**
 * Backend Routes
 */
Route::prefix('admin')->name('admin.')->middleware(['white_list', 'is_login_admin'])->group(function(){
    Route::get('giris', [AuthController::class, 'login'])->name('login');
    Route::post('giris', [AuthController::class, 'loginPost'])->name('login.post');
});

Route::prefix('admin')->name('admin.')->middleware(['white_list', 'isAdmin'])->group(function(){
    Route::get('yonetim', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('profil', [AdminController::class, 'admin'])->name('profile');
    Route::post('profil', [AdminController::class, 'adminPost'])->name('profile.post');

    Route::get('ayarlar', [SettingController::class, 'settings'])->name('settings');
    Route::post('ayarlar', [SettingController::class, 'settingsUpdate'])->name('settings-update');

    Route::get('oyunlar', [GameController::class, 'index'])->name('games');
    Route::get('oyun-ekle', [GameController::class, 'create'])->name('create-game');
    Route::post('oyun-ekle', [GameController::class, 'store'])->name('create-game-post');
    Route::get('oyun-duzenle/{id}', [GameController::class, 'edit'])->name('edit-game');
    Route::post('oyun-duzenle/{id}', [GameController::class, 'update'])->name('edit-game-post');
    Route::get('oyun-sil/{id}', [GameController::class, 'destroy'])->name('delete-game');
    Route::post('oyun-durumu/', [GameController::class, 'switchStatus'])->name('switch-game-status');

    Route::get('kategoriler', [CategoryController::class, 'index'])->name('categories');
    Route::get('kategori-ekle', [CategoryController::class, 'create'])->name('create-category');
    Route::post('kategori-ekle', [CategoryController::class, 'store'])->name('create-category-post');
    Route::get('kategori-duzenle/{id}', [CategoryController::class, 'edit'])->name('edit-category');
    Route::post('kategori-duzenle/{id}', [CategoryController::class, 'update'])->name('edit-category-post');
    Route::get('kategori-sil/{id}', [CategoryController::class, 'destroy'])->name('delete-category');
    Route::post('kategori-durumu/', [CategoryController::class, 'switchStatus'])->name('switch-category-status');

    Route::get('gelistiriciler', [DeveloperController::class, 'index'])->name('developers');
    Route::get('gelistirici-ekle', [DeveloperController::class, 'create'])->name('create-developer');
    Route::post('gelistirici-ekle', [DeveloperController::class, 'store'])->name('create-developer-post');
    Route::get('gelistirici-duzenle/{id}', [DeveloperController::class, 'edit'])->name('edit-developer');
    Route::post('gelistirici-duzenle/{id}', [DeveloperController::class, 'update'])->name('edit-developer-post');
    Route::get('gelistirici-sil/{id}', [DeveloperController::class, 'destroy'])->name('delete-developer');
    Route::post('gelistirici-durumu/', [DeveloperController::class, 'switchStatus'])->name('switch-developer-status');

    Route::get('dagiticilar', [PublisherController::class, 'index'])->name('publishers');
    Route::get('dagitici-ekle', [PublisherController::class, 'create'])->name('create-publisher');
    Route::post('dagitici-ekle', [PublisherController::class, 'store'])->name('create-publisher-post');
    Route::get('dagitici-duzenle/{id}', [PublisherController::class, 'edit'])->name('edit-publisher');
    Route::post('dagitici-duzenle/{id}', [PublisherController::class, 'update'])->name('edit-publisher-post');
    Route::get('dagitici-sil/{id}', [PublisherController::class, 'destroy'])->name('delete-publisher');
    Route::post('dagitici-durumu/', [PublisherController::class, 'switchStatus'])->name('switch-publisher-status');

    Route::get('makaleler', [ArticleController::class, 'index'])->name('articles');
    Route::get('makale-ekle', [ArticleController::class, 'create'])->name('create-article');
    Route::post('makale-ekle', [ArticleController::class, 'store'])->name('create-article-post');
    Route::get('makale-duzenle/{id}', [ArticleController::class, 'edit'])->name('edit-article');
    Route::post('makale-duzenle/{id}', [ArticleController::class, 'update'])->name('edit-article-post');
    Route::get('makale-sil/{id}', [ArticleController::class, 'destroy'])->name('delete-article');
    Route::post('makale-durumu/', [ArticleController::class, 'switchStatus'])->name('switch-article-status');

    Route::get('cikis', [AuthController::class, 'logout'])->name('logout');
});

/**
 * Frontend Routes
 */

Route::middleware('maintenance')->group(function(){
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('tum-oyunlar', [\App\Http\Controllers\frontend\GameController::class, 'list'])->name('all-games');
    Route::get('rastgele-oyun', [HomeController::class, 'randomGame'])->name('random-game');
    Route::get('oyun/{id}', [\App\Http\Controllers\frontend\GameController::class, 'gameDetails'])->name('game');
    Route::get('gelistiriciler', [\App\Http\Controllers\frontend\GameController::class, 'developers'])->name('developers');
    Route::get('gelistirici/{id}', [\App\Http\Controllers\frontend\GameController::class, 'developer'])->name('developer');
    Route::get('dagiticilar', [\App\Http\Controllers\frontend\GameController::class, 'publishers'])->name('publishers');
    Route::get('dagitici/{id}', [\App\Http\Controllers\frontend\GameController::class, 'publisher'])->name('publisher');
    Route::get('hakkinda', [HomeController::class, 'about'])->name('about');
    Route::get('kategori/{id}', [HomeController::class, 'category'])->name('category');
    Route::get('makaleler', [\App\Http\Controllers\frontend\ArticleController::class, 'articles'])->name('articles');
    Route::get('makale/{id}', [\App\Http\Controllers\frontend\ArticleController::class, 'article'])->name('article');
    Route::post('arama', [HomeController::class, 'search'])->name('search');
    Route::get('oto-arama', [HomeController::class, 'autoComplete'])->name('autocompleteSearch');

    Route::middleware('prevent_if_login')->group(function() {
        Route::get('uye-ol', [UserController::class, 'registerForm'])->name('register-form');
        Route::post('uye-ol', [UserController::class, 'registerPost'])->name('register-post');
        Route::get('giris', [UserController::class, 'loginForm'])->name('login-form');
        Route::post('giris', [UserController::class, 'loginPost'])->name('login-post');
        Route::get('/redirect-google', [GoogleAuthService::class, 'redirectToGoogle'])->name('redirect-google');
        Route::get('/callback-google', [GoogleAuthService::class, 'handleGoogleCallback'])->name('handle-google');
        Route::get('/redirect-facebook', [FacebookAuthService::class, 'redirectToFacebook'])->name('redirect-facebook');
        Route::get('/callback-facebook', [FacebookAuthService::class, 'handleFacebookCallback'])->name('handle-facebook');
        Route::get('/redirect-github', [GithubAuthService::class, 'redirectToGithub'])->name('redirect-github');
        Route::get('/callback-github', [GithubAuthService::class, 'handleGithubCallback'])->name('handle-github');
        Route::get('/redirect-linkedin', [LinkedinAuthService::class, 'redirectToLinkedin'])->name('redirect-linkedin');
        Route::get('/callback-linkedin', [LinkedinAuthService::class, 'handleLinkedinCallback'])->name('handle-linkedin');
    });

    Route::middleware(['is_login_user', 'is_verify_email'])->group(function() {
        Route::get('profil', [UserController::class, 'userProfile'])->name('user-profile');
        Route::any('profil-guncelle', [UserController::class, 'updateProfile'])->name('update-profile');
        Route::get('cikis', [UserController::class, 'logout'])->name('user-logout');
    });

    Route::any('mail-gonder', [UserController::class, 'resendVerification'])->name('resend-verification');
    Route::get('profil/dogrula/{token}', [UserController::class, 'verifyAccount'])->name('user-verify');

});
