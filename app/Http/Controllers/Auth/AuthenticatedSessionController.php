<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $recaptcha_version = getSetting("recaptcha_version");
        if(!empty($recaptcha_version) and $recaptcha_version != "Disabled") { 
            $gCaptchaResponse = $request->get('g-recaptcha-response');
            $secret_key = getSetting("recaptcha_secret_key");
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='. $gCaptchaResponse;
            $response = file_get_contents($url);
            $response = json_decode($response);
            if(!$response->success) {
                return redirect()->route('login')->with('alert', trans('Google captcha verification failed!'));
            }
        }
        
        $request->authenticate();

        $request->session()->regenerate();
        if (Auth::user()->role_id == 1) {
            return redirect()->intended(RouteServiceProvider::BACKEND);
        }
        if (Auth::user()->email_verified == 0) {
            return redirect("verify-account");
        }

        return redirect()->intended(RouteServiceProvider::HOME);

    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
