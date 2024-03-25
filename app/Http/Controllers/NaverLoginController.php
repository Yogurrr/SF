<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class NaverLoginController extends Controller
{
    public function redirectToNaver()
    {
        return Socialite::driver('naver')->redirect();
    }

    public function handleNaverCallback()
    {
        try {
            $user = Socialite::with('naver')->user();
            $userToLogin = User::where([
                'provider' => 'naver',
                'socialid' => $user->getId(),
            ])->first();
            if (!$userToLogin) {
                \Log::info('user: ' . json_encode($user));
                $userToLogin = new User([
                    'provider' => 'NAVER',
                    'socialid' => $user->getId(),
                    'token' => $user->token,
                    'name' => $user->getName(),
                ]);
                $userToLogin->save();
            }

            Auth::login($userToLogin);
            return redirect('/calendar');
        } catch (\Exception $e) {
            \Log::info("Naver login error: " . $e->getMessage());
            return redirect('/');
        }
    }


    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
