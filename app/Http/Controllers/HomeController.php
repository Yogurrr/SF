<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class HomeController extends Controller
{
    public function index() 
    {
        return view('index');
    }

    public function loginPerform(Request $request)
    {
        $request->validate([
            'userid' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('userid', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('calendar')
                ->withSuccess('Signed in');
        }

        return redirect("/")->withSuccess('Login details are not valid');
    }

    public function Logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
}
