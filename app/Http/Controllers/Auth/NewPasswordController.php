<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use DB;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }

    public function resetLink($code)
    {
        $reset = DB::table('password_resets')->where('token', $code)->orderBy('created_at', 'desc')->first();
        if(empty($reset) OR $reset->status == 1){
            return redirect()->route('login')->with('alert', trans('Invalid Link'));
        }else{
            return view('auth.reset-password', compact('reset'));
        }
    }


    public function passwordReset(Request $request)
    {

       
        $this->validate($request, [
            'email' => 'required',
            'token' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

        $reset = DB::table('password_resets')->where('token', $request->token)->orderBy('created_at', 'desc')->first();
        $user = \App\Models\User::where('email', $reset->email)->first();

        
        if ($reset->status == 1)
        {
            return redirect()->route('login')->with('alert', trans('Invalid link'));
        }
        else
        {
            if($request->password == $request->password_confirmation)
            {

                $user->password = bcrypt($request->password);
                $user->save();
                DB::table('password_resets')->where('token', $request->token)->update(['status' => 1]);
                // deleteSessionFiles($user->id); // Clearing User Session
                // sendMail($user,'Password Changed','emails.password-changed','',''); // Sending Email
                return redirect()->route('login')->with('msg', trans('Password has been changed'));
            }else{
                return back()->with('alert',  trans('Password not matched'));
            }
        }
    }

}
