<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Schedule;
use App\Models\To_do;

class CalendarController extends Controller
{
    public function calendar() 
    {
        if (Auth::check()) {
            $id = Auth::user()->id;

            $scounts = Schedule::select('sdate', DB::raw('count(*) as count'))
                        ->where('id', $id)
                        ->groupBy('sdate')
                        ->get();

            $tcounts = To_do::select('tdate', DB::raw('count(*) as count'))
                        ->where('id', $id)
                        ->groupBy('tdate')
                        ->get();

            return view('user-service.calendar', ['scounts' => $scounts, 'tcounts' => $tcounts]);
        }

        return redirect("/");
    }

    public function getScheduleByDate(Request $request)
    {
        $id = Auth::user()->id;
        $dateVariable = $request->query('dateVariable');

        $schedules = Schedule::where('sdate', $dateVariable)
                    ->where('id', $id)
                    ->get();

        $todos = To_do::where('tdate', $dateVariable)
                    ->where('id', $id)
                    ->get();

        $returnMap = [
            'schedules' => $schedules->toArray(),
            'todos' => $todos->toArray(),
        ];        

        return response()->json($returnMap);
    }

    // 스케줄 입력
    public function addSchedule(Request $request)
    {
        $request->validate([
            'date_or_num' => 'required',
            'add_and_mod_input' => 'required',
        ]);

        Schedule::create([
            'id' => Auth::user()->id,
            'sdate' => $request->date_or_num,
            'schedule' => $request->add_and_mod_input,
        ]);
        
        return redirect("/calendar");
    }

    // 스케줄 수정
    public function updateSchedule(Request $request)
    {
        $date_or_num = $request->input('date_or_num');
        $add_and_mod_input = $request->input('add_and_mod_input');

        Schedule::where('sno', $date_or_num)->update([
            'schedule' => $add_and_mod_input
        ]);

        return redirect("/calendar");
    }

    // 스케줄 삭제
    public function deleteSchedule(Request $request)
    {
        $num_to_delete = $request->input('num_to_delete');
        Schedule::where('sno', $num_to_delete)->delete();

        return redirect("/calendar");
    }

    // 스케줄 이동
    public function moveSchedule(Request $request)
    {
        $shift_value = $request->input('shift_value');
        $shift_date = $request->input('shift_date');

        Schedule::where('sno', $shift_value)->update([
            'sdate' => $shift_date
        ]);

        return redirect('/calendar');
    }

    // 투두 입력
    public function addTodo(Request $request)
    {
        $request->validate([
            'date_or_num' => 'required',
            'add_and_mod_input' => 'required',
        ]);

        To_do::create([
            'id' => Auth::user()->id,
            'tdate' => $request->date_or_num,
            'to_do' => $request->add_and_mod_input,
        ]);

        return redirect("/calendar");
    }

    // 투두 수정
    public function updateTodo(Request $request)
    {
        $date_or_num = $request->input('date_or_num');
        $add_and_mod_input = $request->input('add_and_mod_input');

        To_do::where('tno', $date_or_num)->update([
            'to_do' => $add_and_mod_input
        ]);

        return redirect("/calendar");
    }

    // 투두 삭제
    public function deleteTodo(Request $request)
    {
        $num_to_delete = $request->input('num_to_delete');
        To_do::where('tno', $num_to_delete)->delete();

        return redirect("/calendar");
    }

    // 체크박스 체크
    public function saveStatus(Request $request)
    {
        $isChecked = $request->input('checked');
        $tnoValue = $request->input('tnoValue');

        To_do::where('tno', $tnoValue)->update([
            'is_checked' => $isChecked
        ]);

        return response()->json();
    }

    public function moveTodo(Request $request)
    {
        $shift_value = $request->input('shift_value');
        $shift_date = $request->input('shift_date');

        To_do::where('tno', $shift_value)->update([
            'tdate' => $shift_date
        ]);

        return redirect("/calendar");
    }
}
