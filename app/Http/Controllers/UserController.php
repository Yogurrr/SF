<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Hash;
use App\Models\User;
use App\Models\Schedule;
use App\Models\To_do;

class UserController extends Controller
{
    public function user() 
    {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $todo = To_do::where('id', $id)->get();

            return view('user-service.user', [
                'todo' => $todo,
            ]);
        }
        return redirect("/");
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ], ['password.confirmed' => '비밀번호 확인이 일치하지 않습니다.',]
        );

        // 현재 비밀번호 일치 여부
        if(!Hash::check($request->current_password, auth()->user()->password)){
            return back()->with("error", "현재 비밀번호가 일치하지 않습니다.");
        }

        // 비밀번호 수정
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with("status", "비밀번호가 성공적으로 변경되었습니다!");
    }

    public function deleteAccount(Request $request) 
    {
        Schedule::where('id', Auth::user()->id)->delete();
        To_do::where('id', Auth::user()->id)->delete();
        User::whereId(auth()->user()->id)->delete();

        return redirect("/");
    }
}
