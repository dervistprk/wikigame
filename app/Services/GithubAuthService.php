<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserVerify;
use App\Notifications\UserRegisteredWithSocial;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mail;
use Socialite;

class GithubAuthService
{
    /**
     * Create a redirect method to GitHub api.
     */
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Return a callback method from GitHub api.
     */

    public function handleGithubCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
        } catch (\Exception $e) {
            flash()->addError('Github ile giriş hatası', 'Hata');
            return redirect()->route('login-form')->withErrors('Github ile giriş yaparken bir sorun oluştu. Lütfen tekrar deneyin.');
        }

        $existing_user = User::where('email', $user->getEmail())->first();

        if ($existing_user) {
            auth()->login($existing_user, true);
            flash()->addSuccess('Sisteme Github servisi ile giriş yaptınız', 'Başarılı');
            return redirect()->route('user-profile');
        } else {
            $password = Str::random(10);
            $token    = $user->token;

            $name_array = explode(' ', $user->getName());
            $surname    = $name_array[count($name_array) - 1];
            unset($name_array[count($name_array) - 1]);
            $name = implode(' ', $name_array);

            $social = 'Github';

            $simplify = trim(strtolower($name . $surname));
            $search   = array('Ç', 'ç', 'Ğ', 'ğ', 'ı', 'İ', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü');
            $replace  = array('c', 'c', 'g', 'g', 'i', 'i', 'o', 'o', 's', 's', 'u', 'u');
            $simplify = str_replace($search, $replace, $simplify);

            $new_user                    = new User;
            $new_user->name              = $name;
            $new_user->surname           = $surname;
            $new_user->email             = $user->getEmail();
            $new_user->user_name         = $simplify . '_' . $user->getId();
            $new_user->password          = \Hash::make($password);
            $new_user->github_id         = $user->getId();
            $new_user->birth_day         = Carbon::now();
            $new_user->about             = 'Github servisi ile kayıt yapıldı.';
            $new_user->is_email_verified = 1;
            $new_user->save();

            UserVerify::create([
                'user_id' => $new_user->id,
                'token'   => $token
            ]);

            $new_user->notify(new UserRegisteredWithSocial($new_user, $password, $social));

            Auth::attempt(['email' => $new_user->email, 'password' => $password], true);
            flash()->addSuccess('Sisteme Github servisi ile üye oldunuz', 'Başarılı');
            return redirect()->route('user-profile')->with('message', $social . ' servisi ile üyelik işleminiz tamamlandı. Şifreniz, mail adresinize gönderildi. Bilgilerinizi <strong><a href="' . route('update-profile') . '" class="link-primary text-decoration-none">Profil Bilgilerimi Güncelle</a></strong> sayfasından değiştirebilirsiniz.');
        }
    }
}
