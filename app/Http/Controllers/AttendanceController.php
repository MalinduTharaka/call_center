<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function attendance($id)
    {
        $today = Carbon::today()->toDateString();
        $now = Carbon::now()->toTimeString();

        // Check if a record exists for the given user and today's date
        $attendance = Attendance::where('user_id', $id)
            ->whereDate('date', $today)
            ->first();

        if ($attendance) {
            // If record exists, update the leave_time
            $attendance->update([
                'leave_time' => $now,
            ]);
        } else {
            // If no record, create new one with arr_time
            Attendance::create([
                'user_id' => $id,
                'date' => $today,
                'arr_time' => $now,
                'leave_time' => null,
            ]);
        }
    }

    public function indextodayattendance()
    {
        $invoices = Invoice::all();
        $users = User::all();
        $attendances = Attendance::whereDate('date', Carbon::today())->get();

        return view('attendance.today-attendance', compact('attendances', 'invoices', 'users'));
    }

    public function addAttendanceAdd(Request $request){
        Attendance::create([
            'user_id' => $request->user_id,
            'date' => Carbon::today(),
            'arr_time' => $request->arr_time,
            'leave_time' => $request->leave_time,
        ]);
        return redirect()->back()->with('success', 'Attendance added successfully');
    }

    public function editTodayAtt(Request $request, $id)
    {
        $attendance = Attendance::find($id);
        $attendance->update([
            'arr_time' => $request->arr_time,
            'leave_time' => $request->leave_time,
        ]);

        return redirect()->back()->with('success', 'Attendance updated successfully');
    }

    public function deleteTodayAtt($id){
        $attendance = Attendance::find($id);
        $attendance->delete();

        return redirect()->back()->with('success', 'Attendance deleted successfully');
    }
}