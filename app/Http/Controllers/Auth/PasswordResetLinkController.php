<?php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Classes\Notifications\NotificationEmails;
use Config;
use Mail;
use Str;

class PasswordResetLinkController extends Controller
{
    use NotificationEmails;
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);


        $user = \App\Models\User::where('email', $request->email)->first();
        if ($user == null){
            return back()->with('alert', 'Email not found!');
        } else {   
            $code = Str::random(30);
            $data["reset_url"] = url('/reset/' . $code);
            $data["name"] = $user->name;
            $data["user_email"] = $user->email;
            $mail = sendEmail($user, 1 ,'', $data); // Sending Email
            if($mail['status']==1){
               DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => $code,
                'status' => 0,
                'created_at' => date("Y-m-d h:i:s")
            ]);  
               return back()->with('msg', "Forget password email sent");            
            }else{
               return back()->with('alert', $mail['msg']);    
            }
            
        }

  
        //  $status == Password::RESET_LINK_SENT
        //             ? back()->with('status', __($status))
        //             : back()->withInput($request->only('email'))
        //                 ->withErrors(['email' => __($status)]);

        //                 print_r($status ); exit;
    }
}
