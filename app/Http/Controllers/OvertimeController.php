<?php

namespace App\Http\Controllers;

use App\Models\Balance;
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

            'type' => 'required',
            'date' => 'required',
            'start_hour' => 'required',
            'end_hour' => 'required|after:start_hour',
            // 'leavetype_id' => 'required',
        ]);

        $stime = $request->start_hour;
        $etime = $request->end_hour;
        $starttime1 = new DateTime($stime);
        $endtime2 = new DateTime($etime);
        $interval = $starttime1->diff($endtime2);
        $hourss = $interval->format('%h');
        $minss = $interval->format('%i');
        $units = round($minss / 30) * 30;
        $mintohour = $units / 60;
        $last = $hourss + $mintohour;

        // dd($last);

        // $hours = $hourss+'1';

        $overtime = new Overtime();
        $overtime->type = $request->type;
        $overtime->date = $request->date;
        $overtime->start_hour = $request->start_hour;
        $overtime->end_hour = $request->end_hour;
        $overtime->hours = $last;
        // $overtime->overtimetype_id = $request->overtimetype_id;
        $overtime->user_id = auth()->user()->id;
        $overtime->status = 'Pending Approval';
        if ($overtime->type == 'weekday') {
            $overtime->value = $last * 1.5;
        } else {
            $overtime->value = $last * 2;
        }

        $overtime->save();

        // dd($partialstoannual);
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

    public function approved($id)
    {
        $overtime = Overtime::find($id);
        $overtime->status = 'Approved';
        $overtime->save();

        if ($overtime->type == 'week-end') {
            $partialstoannua = $overtime->hours / 8;
            $partialstoannual = round($partialstoannua, 2);

            $balances = Balance::where('user_id', $overtime->user->id)->get();
            $subsets = $balances->map(function ($balance) {
                return collect($balance->toArray())

                    ->only(['value', 'leavetype_id'])
                    ->all();
            });
            $final = $subsets->firstwhere('leavetype_id', '1');

            $finalfinal = $final['value'];
            $currentbalance = $finalfinal;

            $newbalance = $currentbalance + $partialstoannual;

            Balance::where([
                ['user_id', $overtime->user->id],
                ['leavetype_id', '1'],
            ])->update(['value' => $newbalance]);
        }
        // if ($leave->leavetype_id == '13' || $leave->leavetype_id == '14') {

        //     $balances = Balance::where('user_id', $leave->user->id)->get();
        //     $subsets = $balances->map(function ($balance) {
        //         return collect($balance->toArray())

        //             ->only(['value', 'leavetype_id'])
        //             ->all();
        //     });
        //     $final = $subsets->firstwhere('leavetype_id', '1');

        //     $finalfinal = $final['value'];
        //     $currentbalanceforannual = $finalfinal;

        //     $newbalance = $currentbalanceforannual - $leave->days;

        //     Balance::where([
        //         ['user_id', $leave->user->id],
        //         ['leavetype_id', '1'],
        //     ])->update(['value' => $newbalance]);
        // } elseif ($leave->leavetype_id == '16' || $leave->leavetype_id == '17') {

        //     $balances = Balance::where('user_id', $leave->user->id)->get();
        //     $subsets = $balances->map(function ($balance) {
        //         return collect($balance->toArray())

        //             ->only(['value', 'leavetype_id'])
        //             ->all();
        //     });
        //     $final = $subsets->firstwhere('leavetype_id', '15');

        //     $finalfinal = $final['value'];
        //     $currentbalanceforannual = $finalfinal;

        //     $newbalance = $currentbalanceforannual - $leave->days;

        //     Balance::where([
        //         ['user_id', $leave->user->id],
        //         ['leavetype_id', '15'],
        //     ])->update(['value' => $newbalance]);
        // } else {
        //     $balances = Balance::where('user_id', $leave->user->id)->get();
        //     $subsets = $balances->map(function ($balance) {
        //         return collect($balance->toArray())

        //             ->only(['value', 'leavetype_id'])
        //             ->all();
        //     });
        //     $final = $subsets->firstwhere('leavetype_id', $leave->leavetype_id);

        //     $finalfinal = $final['value'];
        //     $currentbalance = $finalfinal;

        //     $newbalance = $currentbalance - $leave->days;

        //     Balance::where([
        //         ['user_id', $leave->user->id],
        //         ['leavetype_id', $leave->leavetype_id],
        //     ])->update(['value' => $newbalance]);
        // }

        return redirect()->route('overtimes.approval');

    }

    public function declined($id)
    {
        $overtime = Overtime::find($id);
        $overtime->status = 'Declined';
        $overtime->save();

        return redirect()->route('overtimes.approval');

    }
}
