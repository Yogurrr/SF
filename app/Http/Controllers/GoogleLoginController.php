<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $findUser = User::where('email', $googleUser->email)->first();
            if ($findUser) {
                \Log::info('Found user: ' . $findUser->email);
                Auth::login($findUser);
                return redirect('/calendar');
            } else {
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                ]);
                Auth::login($newUser);
                return redirect('/calendar');
            }
        } catch (\Exception $e) {
            \Log::info("Google login error: " . $e->getMessage());
            return redirect('/');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
