<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Game;
use App\Models\WhiteList;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Mail;

class UserController extends Controller
{
    public function __construct()
    {
    }

    public function registerForm()
    {
        return view('frontend.users.register');
    }

    public function registerPost(Request $request)
    {
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

        Mail::send('frontend.emails.verificationMail', ['token' => $token], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('WikiGame Doğrulama E-Postası');
        });

        return redirect()->route('login-form')->with('message', 'Belirtmiş olduğunuz e-posta adresine bir doğrulama postası gönderildi.<br> Doğrulama postasını almadınız mı? Tekrar göndermek için lütfen <a class="link-primary text-decoration-none" href="' . route('resend-verification') . '">tıklayın</a>.');
    }

    public function resendVerification(Request $request)
    {
        if ($request->isMethod('post')) {
            $token = Str::random(64);

            $user           = User::where('email', $request->email)->first();
            $password_check = $user ? Hash::check($request->password, $user->password) : null;

            if ($user && $password_check) {
                if ($user->isBanned()) {
                    return redirect()->route('resend-verification')->with('message', 'Bilgilerini girdiğiniz hesap sitemizden yasaklanmıştır.');
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

                    Mail::send('frontend.emails.verificationMail', ['token' => $token], function($message) use ($request) {
                        $message->to($request->email);
                        $message->subject('WikiGame Doğrulama E-Postası');
                    });
                    toastr()->success('Doğrulama e-postası tekrar gönderildi.', 'Başarılı');
                    return redirect()->route('login-form')->with('message', 'Doğrulama E-Posta\'sı tekrar gönderildi. Lütfen gelen kutunuzu kontrol edin.');
                } else {
                    toastr()->warning('E-posta daha önce doğrulanmış.', 'Uyarı');
                    return redirect()->route('login-form')->with('message', 'Girmiş olduğunuz e-posta adresi daha önceden doğrulanmış. Şifrenizle giriş yapabilirsiniz.');
                }
            } else {
                toastr()->error('E-posta veya şifre yanlış.', 'Hata');
                return redirect()->route('resend-verification')->with('message', 'Üzgünüz, girmiş olduğunuz e-posta adresi veya şifre yanlış. Lütfen kontrol edip tekrar deneyin.');
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

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember ? true : false)) {
            toastr()->success('Başarıyla giriş yaptınız', 'Başarılı');
            return redirect()->route('user-profile');
        }

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
                    return redirect()->route('update-profile')->withErrors('Mevcut şifrenizi yanlış girdiniz. Lütfen tekrar deneyin.');
                }

                $user_data['password'] = Hash::make($request->password);
            }

            User::where('id', $user->id)->update($user_data);

            toastr()->success('Profil Bilgileri Başarıyla Güncellendi.', 'Başarılı');
            return redirect()->route('user-profile');
        }

        return view('frontend.users.updateProfile', compact('user'));
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

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
            toastr()->success('Yorumunuz başarıyla kaydedildi.', 'Başarılı');
            return redirect()->route('game', $game->slug);
        }

        $game->comments()->save($comment);
        toastr()->warning('Yorumunuz onaylanması için yöneticiye iletildi.', 'Onay Bekliyor');

        //TODO: yorum yayınlanmadan önce yönetici onayına gitsin, kullanıcıya bir bildirim gönderilsin. (eğer yorumu yapan yönetici değilse)
        return redirect()->route('game', $game->slug);
    }

    public function editGameComment(Request $request, $game_id, $comment_id)
    {
        $game    = Game::find($game_id);
        $comment = $game->comments()->findOrFail($comment_id);

        //TODO: yorum düzenlemeden önce yönetici onayına gitsin, kullanıcıya bir bildirim gönderilsin.
        $comment->update(['body' => $request->input('edit_comment')]);
        toastr()->success('Yorum başarıyla kaydedildi.', 'Başarılı');

        return redirect()->route('game', $game->slug);
    }

    public function replyGameComment(Request $request, $game_id, $parent_comment_id)
    {
        //TODO: yönetici onayına gönder, onaydan sonra cevap yazılan kullanıcıya da bildirim gönder.
        $game                = Game::find($game_id);
        $parent_comment_user = Comment::find($parent_comment_id)->user;
        $reply_comment_user  = Auth::user();
        $sub_comment         = new Comment();
        $sub_comment->commentable()->associate($game);
        $sub_comment->user()->associate(Auth::user());
        $sub_comment->body      = $request->input('reply_comment');
        $sub_comment->parent_id = $parent_comment_id;
        $game->comments()->save($sub_comment);
        toastr()->success('Yorum başarıyla kaydedildi.', 'Başarılı');

        return redirect()->route('game', $game->slug);
    }

    public function makeArticleComment(Request $request)
    {
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('home');
    }
}
