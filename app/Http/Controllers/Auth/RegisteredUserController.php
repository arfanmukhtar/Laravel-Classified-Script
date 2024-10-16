<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $code = Str::random(50);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => 3,
            'verification_token' => $code,
            'account_type' => $request->account_type,
            'password' => Hash::make($request->password),
        ]);

        try { 
         
            $data["verification_url"] = url('/account/verify/' . $code);
            $data["name"] = $user->name;
            $data["user_email"] = $user->email;
            $mail = sendEmail($user, 6 ,'', $data); // Sending Email
            if($mail['status']==1){
               $message = "A verification link is sent to your email. Please verify the email.";
               return redirect()->route('login')->with('msg', $message);
            }
        } catch(\Exception $e) {  }
       

        return redirect(RouteServiceProvider::HOME);
    }


    public function verifyAccount($token)
    {
        
        $user = User::where('verification_token', "$token")->first();


        $message = 'Sorry your email cannot be identified.';
  
        if(!is_null($user) ){
            if(!$user->email_verified) {
                User::where("id" , $user->id)->update(["email_verified" => 1 , "verification_token" => ""]);
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
            Auth::login($user);
            return redirect("/");
        } else { 
            $message = "Your verification link is not working. Please login to resend again";
            return redirect()->route('login')->with('alert', $message);
        }
  
     
    }


    public function verifyEmailAccount()
    {
        return view('auth.verify');
    }
    public function resendEmail(Request $request)
    {
        $code = Str::random(50);
        $data["verification_url"] = url('/account/verify/' . $code);
        $user = Auth::user();
        $data["name"] = $user->name;
        $data["user_email"] = $user->email;
        $mail = sendEmail($user, 6 ,'', $data); // Sending Email
        if($mail['status']==1 || 1){
           User::where("id" , $user->id)->update([
             'verification_token' => $code,
             'name' => $request->name,
             'email' => $request->email,
           ]);  
           $message = "Please check your email to verify email.";
            return redirect()->route('verify-account')->with('msg', $message);
        }

        $message = "Email sending failed with contact with support.";
        return redirect()->route('verify-account')->with('alert', $message);
    }


}
