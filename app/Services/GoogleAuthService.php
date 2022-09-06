<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserVerify;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Str;
use Mail;
use Socialite;

class GoogleAuthService
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login-form')->withErrors('Google ile giriş yaparken bir sorun oluştu. Lütfen tekrar deneyin.');
        }

        $existing_user = User::where('email', $user->getEmail())->first();

        if ($existing_user) {
            auth()->login($existing_user, true);
            toastr()->success('Sisteme Google servisi ile giriş yaptınız', 'Başarılı');
            return redirect()->route('user-profile');
        } else {
            $password = Str::random(10);
            $token    = Str::random(64);
            $simplify = trim(strtolower($user->user['given_name'] . $user->user['family_name']));

            $search  = array('Ç', 'ç', 'Ğ', 'ğ', 'ı', 'İ', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü');
            $replace = array('c', 'c', 'g', 'g', 'i', 'i', 'o', 'o', 's', 's', 'u', 'u');

            $simplify = str_replace($search, $replace, $simplify);
            $social   = 'Google';

            $new_user                    = new User;
            $new_user->name              = $user->user['given_name'];
            $new_user->surname           = $user->user['family_name'];
            $new_user->email             = $user->getEmail();
            $new_user->user_name         = $simplify . '_' . $user->getId();
            $new_user->password          = \Hash::make($password);
            $new_user->google_id         = $user->getId();
            $new_user->birth_day         = Carbon::now();
            $new_user->about             = 'Google servisi ile kayıt yapıldı.';
            $new_user->is_email_verified = 1;
            $new_user->save();

            UserVerify::create([
                'user_id' => $new_user->id,
                'token'   => $token
            ]);

            Mail::send('frontend.emails.userPassword', ['password' => $password, 'social' => $social], function($message) use ($new_user) {
                $message->to($new_user->email);
                $message->subject('WikiGame Üyelik Bilgileriniz');
            });

            Auth::attempt(['email' => $new_user->email, 'password' => $password], true);
            return redirect()->route('user-profile')->with('message', $social . ' servisi ile üyelik işleminiz tamamlandı. Şifreniz, mail adresinize gönderildi. Bilgilerinizi <strong><a href="' . route('update-profile') . '" class="link-primary text-decoration-none">Profil Bilgilerimi Güncelle</a></strong> sayfasından değiştirebilirsiniz.');
        }
    }
}