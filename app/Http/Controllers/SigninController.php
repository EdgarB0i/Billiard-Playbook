<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;


class SigninController extends Controller
{
    public function showSigninForm()
    {
        return view('signin');
    }

    public function signin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/')->with('success', 'You have successfully signed in.');
        } else {
            return redirect()->back()->withErrors(['error' => 'One or more credentials do not match.'])->withInput();
        }
    }
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return redirect('/signin')->with('error', 'Facebook login failed. Please try again.');
        }
    
        $existingUser = User::where('email', $facebookUser->getEmail())->first();
    
        if ($existingUser) {
            Auth::login($existingUser);
            return redirect('/')->with('success', 'You have successfully signed in with Facebook.');
        } else {
            // If the user doesn't exist, create a new user record using Facebook data
            $newUser = User::create([
                'name' => $facebookUser->getName(),
                'email' => $facebookUser->getEmail(),
                'password' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            Auth::login($newUser);
            return redirect('/')->with('success', 'You have successfully signed in with Facebook.');
        }
    }
    
    

    public function signout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}


