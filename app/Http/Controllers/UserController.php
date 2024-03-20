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
            $userid = Auth::user()->userid;

            $todo_counts = To_do::select(DB::raw('count(*) as count'))
                        ->where('userid', $userid)
                        ->get();

            $checked_todo_counts = To_do::select(DB::raw('count(*) as count'))
                                ->where('userid', $userid)
                                ->where('is_checked', 1)
                                ->get();

            $todo = To_do::where('userid', $userid)->get();


            return view('user-service.user', [
                'todo_counts' => $todo_counts, 
                'checked_todo_counts' => $checked_todo_counts,
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
        // 현재 비밀번호 일치 여부
        if(!Hash::check($request->password_for_deletion, auth()->user()->password)){
            return back()->with("error2", "현재 비밀번호가 일치하지 않습니다.");
        }

        Schedule::where('userid', Auth::user()->userid)->delete();
        To_do::where('userid', Auth::user()->userid)->delete();
        User::whereId(auth()->user()->id)->delete();

        return redirect("/");
    }
}
