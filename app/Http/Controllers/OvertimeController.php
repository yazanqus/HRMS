<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $overtime = Overtime::where('user_id', $user->id)->get();
        return view('overtimes.index', ['overtimes' => $overtime]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('overtimes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'date' => 'required',
            'start_hour' => 'required',
            'end_hour' => 'required',
            // 'leavetype_id' => 'required',
        ]);

        $stime = $request->start_hour;
        $etime = $request->end_hour;
        $starttime1 = new DateTime($stime);
        $endtime2 = new DateTime($etime);
        $interval = $starttime1->diff($endtime2);
        $hours = $interval->format('%h');
        // $hours = $hourss+'1';

        $overtime = new Overtime();
        $overtime->date = $request->date;
        $overtime->start_hour = $request->start_hour;
        $overtime->end_hour = $request->end_hour;
        $overtime->hours = $hours;
        // $overtime->overtimetype_id = $request->overtimetype_id;
        $overtime->user_id = auth()->user()->id;
        $overtime->status = 'Pending Approval';

        $overtime->save();

        return redirect()->route('overtimes.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function show(Overtime $overtime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function edit(Overtime $overtime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Overtime $overtime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function destroy(Overtime $overtime)
    {
        //
    }
}
