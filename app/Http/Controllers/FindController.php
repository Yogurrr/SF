<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Mail;

class FindController extends Controller
{
    public function findUserid()
    {
        return view('guest-service.find-userid');
    }

    public function getUseridByEmail(Request $request)
    {
        $nameValue = $request->query('nameValue');
        $emailValue = $request->query('emailValue');

        $user = User::where('name', $nameValue)
            ->where('email', $emailValue)
            ->first();

        if ($user) {
            return response()->json(['userid' => $user->userid]);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function findPassword()
    {
        return view('guest-service.find-password');
    }

    public function membershipPresence(Request $request)
    {
        $name = $request->input('name');
        $userid = $request->input('userid');
        $email = $request->input('email');

        $user = User::where('name', $name)
            ->where('userid', $userid)
            ->where('email', $email)
            ->first();

        if ($user) {
            return response()->json(['id' => $user->id]);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function updateTemporaryPassword(Request $request)
    {
        // 메일 보내기
        $data_array = array(
            'name' => $request->input('name'),
            'email_address' => $request->input('email'),
            'userid' => $request->input('userid'),
            'temporary_pswd' => $request->input('temporary_pswd'),
        );

        Mail::send('mail.mail_format', ['data_array' => $data_array], function($message) use ($data_array){
            $message->to($data_array['email_address'])->subject('[스프] 요청하신 임시 비밀번호를 알려드립니다.');
            $message->from('masakisqq@gmail.com');
        });

        // 비밀번호 변경
        User::where('userid', $data_array['userid'])->update([
            'password' => Hash::make($data_array['temporary_pswd'])
        ]);

        return response()->json(['message' => 'Mail sent successfully!']);
    }

    public function sendMail(Request $request){
    	$data_arr = array(
            'name' => $request->input('name'),
            'email_address' => $request->input('email'),
        );

        Mail::send('mail.mail_format', ['data_arr' => $data_arr], function($message) use ($data_arr){
            $message->to($data_arr['email_address'])->subject('[스프] 요청하신 임시 비밀번호를 알려드립니다.');
            $message->from('masakisqq@gmail.com');
        });
        
        return response()->json(['message' => 'Mail sent successfully!']);
    }
}
