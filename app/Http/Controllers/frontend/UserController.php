<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\CommentDislike;
use App\Models\CommentLike;
use App\Models\Game;
use App\Models\WhiteList;
use App\Notifications\CommentDeleted;
use App\Notifications\CommentDisliked;
use App\Notifications\CommentLiked;
use App\Notifications\CommentVerified;
use App\Notifications\SubCommentDeleted;
use App\Notifications\SubCommentDeletedWithParent;
use App\Notifications\SubCommentVerified;
use App\Notifications\UserConfirmation;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct() {}

    public function registerForm()
    {
        return view('frontend.users.register');
    }

    public function registerPost(Request $request)
    {
        //TODO: twitter ile giriş yapabilme ve üye olabilmeyi ekle.
        $request->validate([
            'email'     => 'required|email|unique:users|max:255',
            'user_name' => 'required|min:3|unique:users|max:255|regex:/^[\w-]*$/',
            'password'  => [
                'required',
                'confirmed',
                'min:6',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'max:255'
            ],
            'name'      => 'required|min:2|max:255',
            'surname'   => 'required|min:2|:255',
            'birth_day' => 'required|date',
            'gender'    => 'required',
            'about'     => 'required|min:30|max:500'
        ]);

        $user_field = [
            'email',
            'user_name',
            'name',
            'surname',
            'birth_day',
            'gender',
            'about'
        ];

        foreach ($user_field as $field) {
            $user_data[$field] = $request->input($field);
        }

        $user           = new User($user_data);
        $user->password = Hash::make($request->password);
        $user->save();

        $token = Str::random(64);

        UserVerify::create([
            'user_id' => $user->id,
            'token'   => $token
        ]);

        $user->notify(new UserConfirmation($user, $token));
        flash()->addInfo('Doğrulama e-postası gönderildi.', 'Dikkat!');

        return redirect()->route('login-form')->with(
            'message',
            'Belirtmiş olduğunuz e-posta adresine bir doğrulama postası gönderildi.
             <br> Doğrulama postasını almadınız mı? Tekrar göndermek için lütfen
             <a class="link-primary text-decoration-none" href="' . route('resend-verification') . '">tıklayın</a>.'
        );
    }

    public function resendVerification(Request $request)
    {
        if ($request->isMethod('post')) {
            $token = Str::random(64);

            $user           = User::where('email', $request->email)->first();
            $password_check = $user ? Hash::check($request->password, $user->password) : null;

            if ($user && $password_check) {
                if ($user->isBanned()) {
                    return redirect()->route('resend-verification')->with(
                        'message',
                        'Bilgilerini girdiğiniz hesap sitemizden yasaklanmıştır.'
                    );
                }

                if (!$user->isVerified()) {
                    UserVerify::updateOrCreate(
                        [
                            'user_id' => $user->id,
                        ],
                        [
                            'token' => $token
                        ]
                    );

                    $user->notify(new UserConfirmation($user, $token));

                    flash()->addSuccess('Doğrulama e-postası tekrar gönderildi.', 'Başarılı');
                    return redirect()->route('login-form')->with(
                        'message',
                        'Doğrulama E-Posta\'sı tekrar gönderildi. Lütfen gelen kutunuzu kontrol edin.'
                    );
                } else {
                    flash()->warning('E-posta daha önce doğrulanmış.', 'Uyarı');
                    return redirect()->route('login-form')->with(
                        'message',
                        'Girmiş olduğunuz e-posta adresi daha önceden doğrulanmış. Şifrenizle giriş yapabilirsiniz.'
                    );
                }
            } else {
                flash()->error('E-posta veya şifre yanlış.', 'Hata');
                return redirect()->route('resend-verification')->with(
                    'message',
                    'Üzgünüz, girmiş olduğunuz e-posta adresi veya şifre yanlış. Lütfen kontrol edip tekrar deneyin.'
                );
            }
        }

        return view('frontend.users.reSendVerification');
    }

    public function loginForm()
    {
        return view('frontend.users.login');
    }

    public function loginPost(Request $request)
    {
        $remember = $request->input('remember_token');

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], (bool)$remember)) {
            return redirect()->route('user-profile');
        }

        flash()->addError('E-Posta Adresi veya Şifre Hatalı!', 'Hata');
        return redirect()->route('login-form')->withErrors('E-Posta Adresi veya Şifre Hatalı')->withInput();
    }

    public function userProfile(Request $request)
    {
        $user             = Auth::user();
        $white_list_ips   = WhiteList::get()->toArray();
        $ips              = [];
        $ip_check_message = '';

        foreach ($white_list_ips as $white_list) {
            $ips[] = $white_list['ip'];
        }

        if (!in_array($request->ip(), $ips)) {
            $ip_check_message = 'Cihaz IP adresi, izin verilen IP adresleri listesinde mevcut değil.';
        }

        return view('frontend.users.profile', compact('user', 'ip_check_message'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if ($request->isMethod('post')) {
            $request->validate([
                'name'      => 'required|max:254',
                'surname'   => 'required|max:254',
                'birth_day' => 'required|date',
                'gender'    => 'required',
                'about'     => 'required|min:30|max:500'
            ]);

            $user_field = [
                'name',
                'surname',
                'birth_day',
                'gender',
                'about'
            ];

            foreach ($user_field as $field) {
                $user_data[$field] = $request->input($field);
            }

            if ($request->current_password && $request->password && $request->password_confirmation) {
                $request->validate([
                    'password' => [
                        'confirmed',
                        'min:6',
                        'regex:/[a-z]/',
                        'regex:/[A-Z]/',
                        'regex:/[0-9]/',
                        'max:255',
                        'different:current_password'
                    ],
                ]);

                if (!Hash::check($request->current_password, $user->password)) {
                    return redirect()->route('update-profile')->withErrors(
                        'Mevcut şifrenizi yanlış girdiniz. Lütfen tekrar deneyin.'
                    );
                }

                $user_data['password'] = Hash::make($request->password);
            }

            User::where('id', $user->id)->update($user_data);

            flash()->addSuccess('Profil Bilgileri Başarıyla Güncellendi.', 'Başarılı');
            return redirect()->route('user-profile');
        }

        return view('frontend.users.updateProfile', compact('user'));
    }

    public function verifyAccount($user_id, $token)
    {
        $verifyUser = UserVerify::where([
            ['user_id', '=', $user_id],
            ['token', '=', $token]
        ])->first();

        $message = 'Üzgünüz, girmiş olduğunuz e-posta adresi sistemde bulunamadı. Lütfen kontrol edip tekrar deneyin.';

        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;

            if (!$user->isVerified()) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "E-posta adresi başarıyla doğrulandı. Sisteme giriş yapabilirsiniz.";
            } else {
                $message = "Girmiş olduğunuz e-posta adresi daha önceden doğrulanmış. Şifrenizle giriş yapabilirsiniz.";
            }
        }

        return redirect()->route('login-form')->with('message', $message);
    }

    public function makeGameComment(Request $request, $game_id)
    {
        $game = Game::findOrFail($game_id);

        $request->validate([
            'comment' => 'required|min:30'
        ]);

        $comment = new Comment();
        $comment->commentable()->associate($game);
        $comment->user()->associate(Auth::user());
        $comment->body = $request->input('comment');

        if (Auth::user()->isAdmin()) {
            $comment->is_verified = 1;
            $game->comments()->save($comment);
            flash()->addSuccess('Yorumunuz başarıyla kaydedildi.', 'Başarılı');
            return redirect()->route('game', $game->slug);
        }

        $game->comments()->save($comment);
        flash()->addWarning('Yorumunuz onaylanması için yöneticiye iletildi.', 'Onay Bekliyor');
        return redirect()->route('game', $game->slug);
    }

    public function editGameComment(Request $request, $game_id, $comment_id)
    {
        $request->validate([
            'edit_comment' => 'required|min:30'
        ]);

        $game    = Game::find($game_id);
        $comment = $game->comments()->findOrFail($comment_id);

        if (Auth::user()->isAdmin()) {
            $comment->update([
                'body' => $request->input('edit_comment')
            ]);
            flash()->addSuccess('Yorumunuz başarıyla kaydedildi.', 'Başarılı');
            return redirect()->route('game', $game->slug);
        }

        $comment->update([
            'body'        => $request->input('edit_comment'),
            'is_verified' => 0
        ]);

        flash()->addWarning('Yorumunuz onaylanması için yöneticiye iletildi.', 'Onay Bekliyor');
        return redirect()->route('game', $game->slug);
    }

    public function replyGameComment(Request $request, $game_id, $parent_comment_id, $sub_comment_id = null)
    {
        $request->validate([
            'reply_comment' => 'required|min:30'
        ]);

        $game                = Game::find($game_id);
        $parent_comment_user = Comment::find($parent_comment_id)->user;
        $reply_comment_user  = Auth::user();
        $sub_comment         = new Comment();
        $sub_comment->commentable()->associate($game);
        $sub_comment->user()->associate(Auth::user());
        $sub_comment->body      = $request->input('reply_comment');
        $sub_comment->parent_id = $parent_comment_id;
        $sub_comment_user       = $sub_comment_id ? Comment::find($sub_comment_id)->user : null;

        if (Auth::user()->isAdmin()) {
            if ($sub_comment->commentable_type == 'App\Models\Game') {
                $content = Game::findOrFail($sub_comment->commentable_id);
            } else {
                $content = Article::findOrFail($sub_comment->commentable_id);
            }
            $sub_comment->is_verified = 1;
            $game->comments()->save($sub_comment);

            if ($sub_comment_user) {
                $sub_comment_user->notify(new SubCommentVerified($sub_comment, $content));
            }

            if ($parent_comment_user != $reply_comment_user) {
                $parent_comment_user->notify(new SubCommentVerified($sub_comment, $content));
            }

            $reply_comment_user->notify(new CommentVerified($sub_comment, $content));
            flash()->addSuccess('Yorumunuz başarıyla kaydedildi.', 'Başarılı');
            return redirect()->route('game', $game->slug);
        }

        $game->comments()->save($sub_comment);
        flash()->addWarning('Yorumunuz onaylanması için yöneticiye iletildi.', 'Onay Bekliyor');
        return redirect()->route('game', $game->slug);
    }

    public function likeComment(Request $request)
    {
        if ($request->ajax()) {
            $comment     = Comment::find($request->post('comment_id'));
            $logged_user = Auth::user();

            if ($comment->commentable_type == 'App\Models\Game') {
                $content = Game::findOrFail($comment->commentable_id);
            } else {
                $content = Article::findOrFail($comment->commentable_id);
            }

            foreach ($logged_user->dislikes as $dislike) {
                if ($dislike->comment == $comment) {
                    $dislike->comment->delete();
                    $comment->decrement('dislikes');
                }
            }

            CommentLike::create([
                'user_id'    => $logged_user->id,
                'comment_id' => $comment->id
            ]);

            $comment->increment('likes');
            $comment->user->notify(new CommentLiked($comment, $content, $logged_user));
            return true;
        }
        return false;
    }

    public function dislikeComment(Request $request)
    {
        if ($request->ajax()) {
            $comment     = Comment::find($request->post('comment_id'));
            $logged_user = Auth::user();

            if ($comment->commentable_type == 'App\Models\Game') {
                $content = Game::findOrFail($comment->commentable_id);
            } else {
                $content = Article::findOrFail($comment->commentable_id);
            }

            foreach ($logged_user->likes as $like) {
                if ($like->comment == $comment) {
                    $like->delete();
                    $comment->decrement('likes');
                }
            }

            CommentDislike::create([
                'user_id'    => $logged_user->id,
                'comment_id' => $comment->id
            ]);

            $comment->increment('dislikes');
            $comment->user->notify(new CommentDisliked($comment, $content, $logged_user));
            return true;
        }
        return false;
    }

    public function deleteComment(Request $request)
    {
        if ($request->ajax()) {
            $comment = Comment::find($request->post('comment_id'));

            if ($comment->commentable_type == 'App\Models\Game') {
                $content = Game::findOrFail($comment->commentable_id);
            } else {
                $content = Article::findOrFail($comment->commentable_id);
            }

            $is_sub_comment  = (bool)$comment->parent;
            $flasher_message = 'Yorum başarıyla silindi';

            if ($comment->replies->count() > 0) {
                foreach ($comment->replies as $reply) {
                    $reply->delete();
                    $reply->user->notify(new SubCommentDeletedWithParent($comment, $content));
                }
                $flasher_message = 'Yorum ve cevapları başarıyla silindi';
            }

            $comment->delete();

            if (Auth::user()->id != $comment->user_id) {
                $comment->user->notify(new CommentDeleted($comment, $content));

                if ($comment->parent) {
                    $comment->parent->user->notify(new SubCommentDeleted($comment, $content));
                }
            }

            if ($content->comments->count() == 0) {
                return [
                    'reload'          => true,
                    'result'          => true,
                    'is_sub_comment'  => $is_sub_comment,
                    'flasher_message' => $flasher_message
                ];
            } else {
                return [
                    'reload'          => false,
                    'result'          => true,
                    'is_sub_comment'  => $is_sub_comment,
                    'flasher_message' => $flasher_message
                ];
            }
        }
        return false;
    }

    public function makeArticleComment(Request $request) {}

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('home');
    }
}
