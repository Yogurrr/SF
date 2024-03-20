<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class JoinController extends Controller
{
    public function join() 
    {
        return view('guest-service.join');
    }

    public function joinPerform(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'userid' => 'required',
            'password' => 'required|min:6',
            'email' => 'required|email|unique:users',
        ]);

        $data = $request->all();
        $check = $this->create($data);
        
        return redirect("/")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'userid' => $data['userid'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
        ]);
    }
}
