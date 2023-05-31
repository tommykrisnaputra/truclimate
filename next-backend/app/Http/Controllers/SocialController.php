<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SocialController extends Controller
{
    public function twitterRedirect(){
        return Socialite::driver('twitter')->redirect();
    }

    public function twitterCallback(){
        $user = Socialite::driver('twitter')->user();
        $this->_registerOrLoginTwitterUser($user);
        // return redirect()->route('/dashboard');
        return redirect('http://localhost:3000/dashboard');
    }

    protected function _registerOrLoginTwitterUser($incomingUser) {
        $user = User::where('twitter_id', $incomingUser->id)->first();
        if (!$user) {
            $user = new User();
            $user->name = $incomingUser->name;
            $user->email = $incomingUser->email;
            $user->twitter_id = $incomingUser->id;
            $user->password = encrypt('password');
            $user->save();
        }
        Auth::login($user);
    }

    public function githubRedurect(){
        return Socialite::driver('github')->redirect();
    }
}
