<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Socialite;

class SocialController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider, Request $request)
    {
        try {

            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }

        $email = $socialUser->getEmail();
        if (empty($email)) {
            $redirect = 'signup?error=1';

            return redirect("$redirect");
        }
        if ($provider == 'google') {
            $socialProvider = User::where('email', $socialUser->getEmail())->first();
            $provider_id = 'google_id';
        }
        if ($provider == 'facebook') {
            $provider_id = 'facebook_id';
            $socialProvider = User::where('email', $socialUser->getEmail())->first();
        }
        if ($provider == 'linkedin') {
            $provider_id = 'linkedin_id';
            $socialProvider = User::where('email', $socialUser->getEmail())->first();
        }
        //check if we have logged provider

        if (! $socialProvider) {

            $email = $socialUser->getEmail();
            $data['email'] = $email;
            $data['name'] = $socialUser->getName();
            $data['package_id'] = 1;
            $data['email_verified'] = 1;
            $data['provider'] = $provider;
            // $data["provider_id"] = $socialUser->getId();
            $data[$provider_id] = $socialUser->getId();

            $user_id = User::insertGetId($data);

            $user = \App\User::find($user_id);
            // //// send a verfication Email

            $redirect = '/';
        } else {

            $user = User::find($socialProvider->id);
            $redirect = '/';
        }

        auth()->login($user);

        User::where('id', $user->id)->update(['last_loggedin' => gmdate('Y-m-d H:i:s')]);


        return redirect("$redirect");

    }
}
