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

    // 아이디 중복 확인
    public function checkIdDuplication(Request $request)
    {
        $userid = $request -> input('userid_value');
        $user = User::where('userid', $userid)->first();

        if ($user) {
            return response()->json(['id' => $user->id]);
        } else {
            return response()->json(['message' => 'User not found']);
        }
    }
}
