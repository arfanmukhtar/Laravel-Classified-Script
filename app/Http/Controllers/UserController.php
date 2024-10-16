<?php

namespace App\Http\Controllers;

use App\Models\UserFollow;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function followUser(Request $request)
    {
        $follower = $request->input('user_id');
        $user_id = Auth::user()->id;
        $exists = UserFollow::where('user_id', $follower)->where('followed_by', $user_id)->exists();
        if ($exists) {
            echo 'already';
            exit;
        }
        UserFollow::insert([
            'followed_by' => $user_id,
            'user_id' => $follower,
        ]);

        echo 'success';
    }
}
