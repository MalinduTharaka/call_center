<?php

namespace App\Http\Controllers;

use App\Events\AdvertiserEndWorkEvent;
use App\Models\AdvertiserWork;
use App\Models\Attendance;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function attendance(Request $request, $id)
    {
        $today = Carbon::today()->toDateString();
        $now = $request->input('time') ?? Carbon::now()->toTimeString();

        $attendance = Attendance::where('user_id', $id)
            ->whereDate('date', $today)
            ->first();

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.',
            ]);
        }

        if ($attendance) {
            if (!empty($attendance->arr_time) && is_null($attendance->leave_time)) {
                $arrTime = Carbon::parse($attendance->arr_time);
                $currentTime = Carbon::parse($now);

                if ($arrTime->diffInMinutes($currentTime) > 60) {
                    $attendance->update([
                        'leave_time' => $now,
                    ]);

                    // ✅ Update AdvertiserWork if user is advertiser (role == 'adv')
                    if ($user->role === 'adv') {
                        $advertiserWork = AdvertiserWork::where('user_id', $id)
                            ->whereDate('date', $today)
                            ->first();

                        if ($advertiserWork) {
                            $advertiserWork->update([
                                'off_time' => $now,
                            ]);
                        }
                    }

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Leave time recorded successfully.',
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Cannot record leave time. Less than 1 hour since arrival.',
                    ]);
                }
            } elseif (!empty($attendance->arr_time) && !is_null($attendance->leave_time)) {
                return response()->json([
                    'status' => 'info',
                    'message' => 'Attendance already completed for today.',
                ]);
            } else {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Unexpected attendance state. Please contact admin.',
                ]);
            }
        } else {
            Attendance::create([
                'user_id' => $id,
                'date' => $today,
                'arr_time' => $now,
                'leave_time' => null,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Arrival time recorded successfully.',
            ]);
        }
    }




    public function indextodayattendance()
    {
        $invoices = Invoice::where('due_date', Carbon::today())->get();
        $users = User::all();
        $attendances = Attendance::whereDate('date', Carbon::today())->get();

        return view('attendance.today-attendance', compact('attendances', 'invoices', 'users'));
    }

    public function addAttendanceAdd(Request $request)
    {
        Attendance::create([
            'user_id' => $request->user_id,
            'date' => Carbon::today(),
            'arr_time' => $request->arr_time,
            'leave_time' => $request->leave_time,
        ]);
        $userId = $request->user_id;
        $endTime = $request->leave_time;
        // dd($endTime);
        event(new AdvertiserEndWorkEvent($userId, $endTime));
        return redirect()->back()->with('success', 'Attendance added successfully');
    }

    public function editTodayAtt(Request $request, $id)
    {
        $attendance = Attendance::find($id);
        $attendance->update([
            'arr_time' => $request->arr_time,
            'leave_time' => $request->leave_time,
        ]);
        $userId = $request->user_id;
        $endTime = $request->leave_time;

        event(new AdvertiserEndWorkEvent($userId, $endTime));

        return redirect()->back()->with('success', 'Attendance updated successfully');
    }

    public function deleteTodayAtt($id)
    {
        $attendance = Attendance::find($id);
        $attendance->delete();

        return redirect()->back()->with('success', 'Attendance deleted successfully');
    }

    public function indexAttendanceReport()
    {
        $invoices = Invoice::where('due_date', Carbon::today())->get();
        $users = User::all();
        return view('attendance.attendance-report', compact('invoices', 'users'));
    }

    public function thisMonth($id)
    {
        $attendances = Attendance::where('user_id', $id)
            ->whereMonth('date', Carbon::now()->month)
            ->get();

        return response()->json($attendances);
    }
    public function attendanceMonth(Request $request, $id)
    {
        $attendances = Attendance::where('user_id', $id)
            ->whereMonth('date', $request->month)
            ->whereYear('date', $request->year)
            ->get();

        return response()->json($attendances);
    }
    public function getAttendance($userId, $date)
    {
        $record = Attendance::where('user_id', $userId)->where('date', $date)->first();
        return response()->json($record ?? ['arr_time' => null, 'leave_time' => null]);
    }

    public function updateAttendance(Request $request)
    {
        $attendance = Attendance::updateOrCreate(
            ['user_id' => $request->user_id, 'date' => $request->date],
            ['arr_time' => $request->arr_time, 'leave_time' => $request->leave_time]
        );

        return response()->json(['status' => 'success', 'data' => $attendance]);
    }

}
