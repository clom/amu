<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\SocialAccount;

class SocialLoginController extends Controller
{

    protected $redirectTo = '/';

    public function yahoo_auth(){
        return Socialite::driver('yahoo')->redirect();
    }

    public function yahoo_callback(){
        $user = Socialite::driver('yahoo')->user();
        $user_info = $this->createOrGetUser($user, 'yahoo');

        Auth::login($user_info, true);

        return redirect($this->redirectTo);
    }

    public function createOrGetUser($providerUser, $provider)
    {
        $account = SocialAccount::firstOrCreate([
            'provider_user_id' => $providerUser->getId(),
            'provider'         => $provider,
        ]);

        if (empty($account->user))
        {
            $user = User::create([
                'name'   => $providerUser->getName(),
                'email'  => $providerUser->getEmail(),
                'avatar' => $providerUser->getAvatar(),
            ]);
            $account->user()->associate($user);
        }

        $account->provider_access_token = $providerUser->token;
        $account->save();

        return $account->user;
    }
}
