<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserVerify;
use App\Notifications\UserRegisteredWithSocial;
use Carbon\Carbon;
use Auth;
use Hash;
use Illuminate\Support\Str;
use Socialite;

class TwitterAuthService
{
    //TODO: twitter ve facebook apiler hatalı düzelt.(facebook için ssl sertifikası gerekli.)
    private $social = 'Twitter';

    /**
     * Create a redirect method to twitter api.
     */
    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Return a callback method from twitter api.
     */
    public function handleTwitterCallback()
    {
        try {
            $user = Socialite::driver('twitter')->user();
        } catch (\Exception $e) {
            flash()->addError(trans('messages.register_with_social_error', ['social' => $this->social]), __('Hata'));
            return redirect()->route('login-form')->withErrors(trans('messages.register_with_social_error_msg', ['social' => 'Facebook']));
        }

        $existing_user = User::where('email', $user->getEmail())->first();

        if ($existing_user) {
            auth()->login($existing_user, true);
            flash()->addSuccess(trans('messages.welcome_message', ['name' => Auth::user()->name, 'surname' => Auth::user()->surname]),
                __('Hoşgeldiniz'));
            return redirect()->route('user-profile');
        } else {
            $password = Str::random(10);
            $token    = Str::random(64);

            $name_array = explode(' ', $user->getName());
            $surname    = $name_array[count($name_array) - 1];
            unset($name_array[count($name_array) - 1]);
            $name = implode(' ', $name_array);

            $simplify = trim(strtolower($name . $surname));
            $search   = array('Ç', 'ç', 'Ğ', 'ğ', 'ı', 'İ', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü');
            $replace  = array('c', 'c', 'g', 'g', 'i', 'i', 'o', 'o', 's', 's', 'u', 'u');
            $simplify = str_replace($search, $replace, $simplify);

            $new_user                    = new User;
            $new_user->name              = $name;
            $new_user->surname           = $surname;
            $new_user->email             = $user->getEmail();
            $new_user->user_name         = $simplify . '_' . $user->getId();
            $new_user->password          = Hash::make($password);
            $new_user->google_id         = $user->getId();
            $new_user->birth_day         = Carbon::now();
            $new_user->about             = trans('messages.register_with_social_bio', ['social' => $this->social]);
            $new_user->is_email_verified = 1;
            $new_user->save();

            UserVerify::create([
                'user_id' => $new_user->id,
                'token'   => $token
            ]);

            $new_user->notify(new UserRegisteredWithSocial($new_user, $password, $this->social));

            Auth::attempt(['email' => $new_user->email, 'password' => $password], true);
            flash()->addSuccess(trans('messages.register_with_social_success', ['social' => $this->social]), __('Başarılı'));
            return redirect()->route('user-profile')->with(
                'message',
                trans('messages.register_with_social_feedback', ['social' => $this->social])
            );
        }
    }
}
