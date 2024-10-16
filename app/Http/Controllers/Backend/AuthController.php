<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Auth;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function login()
    {
        if (! empty(Auth::user()) and Auth::user()->role_id == 1) {
            return redirect('admin/dashboard');
        }
        if (! empty(Auth::user())) {
            return redirect('/');
        }

        return view('backend.auth.login');
    }
}
