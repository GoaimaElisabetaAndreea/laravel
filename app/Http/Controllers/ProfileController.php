<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller{

    public function user($username)
    {
        $user = User::where('username',$username)->first();
        if($user) {
            return view('profile.user')->with('user',$user);
        }
       return abort(404);
    }
}
