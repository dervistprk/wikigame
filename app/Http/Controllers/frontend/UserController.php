<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Settings;
use App\Models\WhiteList;
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
        view()->share('categories', Categories::where('status', '=', 1)->orderBy('name', 'asc')->get());
        view()->share('settings', Settings::find(1));
    }

    public function registerForm()
    {
        return view('frontend.users.register');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
               'email'     => 'required|email|unique:users|max:254',
               'user_name' => 'required|min:3|unique:users|max:254|regex:/^[\w-]*$/',
               'password'  => [
                   'required',
                   'confirmed',
                   'min:6',
                   'regex:/[a-z]/',
                   'regex:/[A-Z]/',
                   'regex:/[0-9]/',
               ],
               'name'      => 'required|max:254',
               'surname'   => 'required|max:254',
               'birth_day' => 'required|date',
               'gender'    => 'required',
               'about'     => 'required|min:30'
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
        $user->password = \Hash::make($request->password);
        $user->save();

        $token = Str::random(64);

        UserVerify::create([
                               'user_id' => $user->id,
                               'token'   => $token
                           ]);

        Mail::send('frontend.emails.verificationMail', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('WikiGame Doğrulama E-Postası');
        });

        $route = route('resend-verification');
        return redirect()->route('login-form')->with('message', 'Belirtmiş olduğunuz e-posta adresine bir doğrulama postası gönderildi.<br> Doğrulama postasını almadınız mı? Tekrar göndermek için lütfen <a class="link-danger text-decoration-none" href="' . $route .'">tıklayın</a>.');

    }

    public function resendVerification(Request $request)
    {
        if ($request->isMethod('post')) {
            $token = Str::random(64);

            $user           = User::where('email', $request->email)->first();
            $password_check = \Hash::check($request->password, $user->password);

            if ($user && $password_check) {
                if (!$user->is_email_verified) {
                    UserVerify::updateOrCreate(
                        [
                            'user_id' => $user->id,
                        ],
                        [
                            'token' => $token
                        ]
                    );

                    Mail::send('frontend.emails.verificationMail', ['token' => $token], function($message) use($request){
                        $message->to($request->email);
                        $message->subject('WikiGame Doğrulama E-Postası');
                    });
                    return redirect()->route('login-form')->with('message', 'Doğrulama E-Posta\'sı tekrar gönderildi. Lütfen gelen kutunuzu kontrol ediniz.');
                } else {
                    return redirect()->route('login-form')->with('message', 'Girmiş olduğunuz e-posta adresi daha önceden doğrulanmış. Şifrenizle giriş yapabilirsiniz.');
                }
            } else {
                return redirect()->route('resend-verification')->with('message', 'Üzgünüz, girmiş olduğunuz e-posta adresi veya şifre yanlış. Lütfen kontrol edip tekrar deneyiniz.');
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
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('user-profile');
        }
        return redirect()->route('login-form')->withErrors('E-Posta Adresi veya Şifre Hatalı')->withInput();
    }

    public function userProfile(Request $request)
    {
        if(Auth::check()){
            $user = Auth::user();
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

        return redirect()->route('login-form')->with('message', 'Bu sayfayı görmek için lütfen giriş yapın!');
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
                   'about'     => 'required|min:30'
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

            User::where('id', $user->id)->update($user_data);

            return redirect()->route('user-profile')->with('message', 'Profil Bilgileri Başarıyla Güncellendi.');

        }

        return view('frontend.users.updateProfile', compact('user'));
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        $message = 'Üzgünüz, girmiş olduğunuz e-posta adresi sistemde bulunamadı. Lütfen kontrol edip tekrar deneyiniz.';

        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;

            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "E-posta adresi başarıyla doğrulandı. Sisteme giriş yapabilirsiniz.";
            } else {
                $message = "Girmiş olduğunuz e-posta adresi daha önceden doğrulanmış. Şifrenizle giriş yapabilirsiniz.";
            }
        }

        return redirect()->route('login-form')->with('message', $message);
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect()->route('home');
    }
}
