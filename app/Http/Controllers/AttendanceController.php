<?php

namespace App\Http\Controllers;

use App\Exports\AttendancesExport;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendance::whereNull('user_id')->get();
        return view('attendances.index', ['attendances' => $attendances]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {

        $user = Auth::user();
        $monthshow = $attendance->month;
        if ($attendance->month == 'January') {
            $search = '-01-';
            $attendances = Attendance::where([
                ['user_id', $user->id],
                ['day', 'LIKE', '%' . $search . '%']])->get();
        } //end januaury if

        if ($attendance->month == 'February') {
            $search = '-02-';
            $attendances = Attendance::where([
                ['user_id', $user->id],
                ['day', 'LIKE', '%' . $search . '%']])->get();
        } //end januaury if

        if ($attendance->month == 'March') {
            $search = '-03-';
            $attendances = Attendance::where([
                ['user_id', $user->id],
                ['day', 'LIKE', '%' . $search . '%']])->get();
        } //end januaury if

        if ($attendance->month == 'April') {

            $search = '-04-';
            $attendances = Attendance::where([
                ['user_id', $user->id],
                ['day', 'LIKE', '%' . $search . '%']])->get();
        } //end januaury if
        if ($attendance->month == 'May') {
            $search = '-05-';
            $attendances = Attendance::where([
                ['user_id', $user->id],
                ['day', 'LIKE', '%' . $search . '%']])->get();
        } //end januaury if
        if ($attendance->month == 'June') {
            $search = '-06-';
            $attendances = Attendance::where([
                ['user_id', $user->id],
                ['day', 'LIKE', '%' . $search . '%']])->get();
        } //end januaury if
        if ($attendance->month == 'July') {
            $search = '-07-';
            $attendances = Attendance::where([
                ['user_id', $user->id],
                ['day', 'LIKE', '%' . $search . '%']])->get();
        } //end januaury if
        if ($attendance->month == 'August') {
            $search = '-08-';
            $attendances = Attendance::where([
                ['user_id', $user->id],
                ['day', 'LIKE', '%' . $search . '%']])->get();
        } //end januaury if
        if ($attendance->month == 'September') {
            $search = '-09-';
            $attendances = Attendance::where([
                ['user_id', $user->id],
                ['day', 'LIKE', '%' . $search . '%']])->get();
        } //end januaury if
        if ($attendance->month == 'October') {
            $search = '-10-';
            $attendances = Attendance::where([
                ['user_id', $user->id],
                ['day', 'LIKE', '%' . $search . '%']])->get();
        } //end januaury if
        if ($attendance->month == 'November') {
            $search = '-11-';
            $attendances = Attendance::where([
                ['user_id', $user->id],
                ['day', 'LIKE', '%' . $search . '%']])->get();
        } //end januaury if
        if ($attendance->month == 'December') {
            $search = '-12-';
            $attendances = Attendance::where([
                ['user_id', $user->id],
                ['day', 'LIKE', '%' . $search . '%']])->get();
        } //end januaury if

        if (count($attendances)) {

            return view('attendances.show', [
                'user' => $user,
                'attendances' => $attendances,
                'month' => $monthshow,
            ]);
        } else {
            return view('attendances.notavailable', [
                'user' => $user,

                'month' => $monthshow,
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {

    }

    public function lmapproval()
    {
        $attendances = Attendance::whereNull('user_id')->get();
        return view('approval.attendances.index', ['attendances' => $attendances]);
    }

    public function hrapproval()
    {
        $attendances = Attendance::whereNull('user_id')->get();
        return view('hrapproval.attendances.index', ['attendances' => $attendances]);
    }

    public function submit($user, $month)
    {

        Attendance::where([
            ['user_id', $user],
            ['month', $month]])->update(['status' => 'Pending LM Approval']);

        return redirect()->back();
    }

    public function approved($user, $month)
    {

        Attendance::where([
            ['user_id', $user],
            ['month', $month]])->update(['status' => 'Pending HR Approval']);

        if ($month == 'January') {
            $attendance = '1';
        } elseif ($month == 'February') {
            $attendance = '2';
        } elseif ($month == 'March') {
            $attendance = '3';
        } elseif ($month == 'April') {
            $attendance = '4';
        } elseif ($month == 'May') {
            $attendance = '5';
        } elseif ($month == 'June') {
            $attendance = '6';
        } elseif ($month == 'July') {
            $attendance = '7';
        } elseif ($month == 'August') {
            $attendance = '8';
        } elseif ($month == 'September') {
            $attendance = '9';
        } elseif ($month == 'October') {
            $attendance = '10';
        } elseif ($month == 'November') {
            $attendance = '11';
        } elseif ($month == 'December') {
            $attendance = '12';
        }

        return redirect()->route('attendances.approval.lm.staff', ['attendance' => $attendance]);
    }

    public function declined($user, $month)
    {

        Attendance::where([
            ['user_id', $user],
            ['month', $month]])->update(['status' => 'Declined by LM']);

        if ($month == 'January') {
            $attendance = '1';
        } elseif ($month == 'February') {
            $attendance = '2';
        } elseif ($month == 'March') {
            $attendance = '3';
        } elseif ($month == 'April') {
            $attendance = '4';
        } elseif ($month == 'May') {
            $attendance = '5';
        } elseif ($month == 'June') {
            $attendance = '6';
        } elseif ($month == 'July') {
            $attendance = '7';
        } elseif ($month == 'August') {
            $attendance = '8';
        } elseif ($month == 'September') {
            $attendance = '9';
        } elseif ($month == 'October') {
            $attendance = '10';
        } elseif ($month == 'November') {
            $attendance = '11';
        } elseif ($month == 'December') {
            $attendance = '12';
        }
        return redirect()->route('attendances.approval.lm.staff', ['attendance' => $attendance]);return redirect()->back();
    }

    public function hrapproved($user, $month)
    {

        Attendance::where([
            ['user_id', $user],
            ['month', $month]])->update(['status' => 'Approved']);

        if ($month == 'January') {
            $attendance = '1';
        } elseif ($month == 'February') {
            $attendance = '2';
        } elseif ($month == 'March') {
            $attendance = '3';
        } elseif ($month == 'April') {
            $attendance = '4';
        } elseif ($month == 'May') {
            $attendance = '5';
        } elseif ($month == 'June') {
            $attendance = '6';
        } elseif ($month == 'July') {
            $attendance = '7';
        } elseif ($month == 'August') {
            $attendance = '8';
        } elseif ($month == 'September') {
            $attendance = '9';
        } elseif ($month == 'October') {
            $attendance = '10';
        } elseif ($month == 'November') {
            $attendance = '11';
        } elseif ($month == 'December') {
            $attendance = '12';
        }

        return redirect()->route('attendances.approval.hr.staff', ['attendance' => $attendance]);
    }

    public function hrdeclined($user, $month)
    {

        Attendance::where([
            ['user_id', $user],
            ['month', $month]])->update(['status' => 'Declined by HR']);

        if ($month == 'January') {
            $attendance = '1';
        } elseif ($month == 'February') {
            $attendance = '2';
        } elseif ($month == 'March') {
            $attendance = '3';
        } elseif ($month == 'April') {
            $attendance = '4';
        } elseif ($month == 'May') {
            $attendance = '5';
        } elseif ($month == 'June') {
            $attendance = '6';
        } elseif ($month == 'July') {
            $attendance = '7';
        } elseif ($month == 'August') {
            $attendance = '8';
        } elseif ($month == 'September') {
            $attendance = '9';
        } elseif ($month == 'October') {
            $attendance = '10';
        } elseif ($month == 'November') {
            $attendance = '11';
        } elseif ($month == 'December') {
            $attendance = '12';
        }
        return redirect()->route('attendances.approval.hr.staff', ['attendance' => $attendance]);return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        // $user = Auth::user();

        if (!isset($attendance->start_hour)) {

            $request->validate([
                'start_hour' => 'required',
                'end_hour' => 'required|after_or_equal:start_hour',
            ]);

            Attendance::where([
                ['id', $attendance->id],
            ])->update([
                'start_hour' => $request->start_hour,
                'end_hour' => $request->end_hour,
                'leave_overtime_id' => $request->leave_overtime_id,
                'remarks' => $request->remarks,
            ]);

            return redirect()->back();

        }
        if (isset($attendance->start_hour)) {

            if (isset($attendance->leave_overtime_id)) {
                Attendance::where([
                    ['id', $attendance->id],
                ])->update([
                    'remarks' => $request->remarks,
                ]);

                return redirect()->back();

            } elseif (isset($attendance->remarks)) {
                Attendance::where([
                    ['id', $attendance->id],
                ])->update([
                    'leave_overtime_id' => $request->leave_overtime_id,
                ]);

                return redirect()->back();

            } else {
                Attendance::where([
                    ['id', $attendance->id],
                ])->update([
                    'remarks' => $request->remarks,
                    'leave_overtime_id' => $request->leave_overtime_id,
                ]);
                return redirect()->back();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        Attendance::where([
            ['id', $attendance->id],
        ])->update([
            'start_hour' => null,
            'end_hour' => null,
            'leave_overtime_id' => null,
            'remarks' => null,
        ]);

        return redirect()->back();
    }

    public function export()
    {
        return Excel::download(new AttendancesExport, 'attendances.xlsx');
    }

}
