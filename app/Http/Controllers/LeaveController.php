<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Leave;
use App\Models\Leavetype;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $leave = Leave::where('user_id', $user->id)->get();
        return view('leaves.index', ['leaves' => $leave]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leavetypes = Leavetype::all();
        return view('leaves.create', ['leavetypes' => $leavetypes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // getting the balance for the user for the inserted leave type
        $user = Auth::user();
        $balances = Balance::where('user_id', $user->id)->get();
        $subsets = $balances->map(function ($balance) {
            return collect($balance->toArray())

                ->only(['value', 'leavetype_id'])
                ->all();
        });
        $final = $subsets->firstwhere('leavetype_id', $request->leavetype_id);
        $finalfinal = $final['value'];
        $currentbalance = $finalfinal;

        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'leavetype_id' => 'required',
        ]);

        $fdate = $request->start_date;
        $ldate = $request->end_date;
        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($ldate);
        $interval = $datetime1->diff($datetime2);
        $dayss = $interval->format('%a');
        $days = $dayss+'1';

        $datenow = Carbon::now();
        $joineddate = new DateTime($user->joined_date);
        $dateenow = new DateTime($datenow);
        $intervall = $joineddate->diff($dateenow);
        $probationdays = $intervall->format('%a');

        // Annual leave conditions
        if ($request->leavetype_id == '1') {

            if ($probationdays >= '90') {

                if ($days <= $currentbalance) {

                    $leave = new Leave();
                    $leave->start_date = $request->start_date;
                    $leave->end_date = $request->end_date;
                    $leave->days = $days;
                    $leave->leavetype_id = $request->leavetype_id;
                    $leave->user_id = auth()->user()->id;
                    $leave->status = 'Pending Approval';

                    $leave->save();

                    return redirect()->route('leaves.index');
                }
            } else {
                echo 'you are still on probation';
            }
        }

        // Marriage leave conditions
        elseif ($request->leavetype_id == '5') {

            if ($probationdays >= '180') {

                if ($days <= $currentbalance) {

                    $leave = new Leave();
                    $leave->start_date = $request->start_date;
                    $leave->end_date = $request->end_date;
                    $leave->days = $days;
                    $leave->leavetype_id = $request->leavetype_id;
                    $leave->user_id = auth()->user()->id;
                    $leave->status = 'Pending Approval';

                    $leave->save();

                    return redirect()->route('leaves.index');
                }
            } else {
                echo 'you cant apply for marriage leave yet';
            }

        }

        // Maternity leave coditions
        elseif ($request->leavetype_id == '8') {

            if ($probationdays >= '180') {

                if ($days <= $currentbalance) {

                    $leave = new Leave();
                    $leave->start_date = $request->start_date;
                    $leave->end_date = $request->end_date;
                    $leave->days = $days;
                    $leave->leavetype_id = $request->leavetype_id;
                    $leave->user_id = auth()->user()->id;
                    $leave->status = 'Pending Approval';

                    $leave->save();

                    return redirect()->route('leaves.index');
                }
            } else {
                echo 'you cant apply for marriage leave yet';
            }
        }

        // Paternity leave coditions
        elseif ($request->leavetype_id == '9') {

            if ($probationdays >= '180') {

                if ($days <= $currentbalance) {

                    $leave = new Leave();
                    $leave->start_date = $request->start_date;
                    $leave->end_date = $request->end_date;
                    $leave->days = $days;
                    $leave->leavetype_id = $request->leavetype_id;
                    $leave->user_id = auth()->user()->id;
                    $leave->status = 'Pending Approval';

                    $leave->save();

                    return redirect()->route('leaves.index');
                }
            } else {
                echo 'you cant apply for marriage leave yet';
            }
        } else {
            $leave = new Leave();
            $leave->start_date = $request->start_date;
            $leave->end_date = $request->end_date;
            $leave->days = $days;
            $leave->leavetype_id = $request->leavetype_id;
            $leave->user_id = auth()->user()->id;
            $leave->status = 'Pending Approval';

            $leave->save();

            $data = ['foo' => 'baz'];

            Mail::send('danial@admin.com', $data, function ($message) use ($user) {
                $message->to('danial@admin.com');
                $message->subject('Welcome Mail');
            });

            return redirect()->route('leaves.index');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave)
    {
        //
    }

    public function approved($id)
    {
        $leave = Leave::find($id);
        $leave->status = 'approved';
        $leave->save();

        $balances = Balance::where('user_id', $leave->user->id)->get();
        $subsets = $balances->map(function ($balance) {
            return collect($balance->toArray())

                ->only(['value', 'leavetype_id'])
                ->all();
        });
        $final = $subsets->firstwhere('leavetype_id', $leave->leavetype_id);

        $finalfinal = $final['value'];
        $currentbalance = $finalfinal;

        $newbalance = $currentbalance - $leave->days;

        Balance::where([
            ['user_id', $leave->user->id],
            ['leavetype_id', $leave->leavetype_id],
        ])->update(['value' => $newbalance]);

        return redirect()->route('approval');

    }

    public function declined($id)
    {
        $leave = Leave::find($id);
        $leave->status = 'declined';
        $leave->save();

        return redirect()->route('approval');

    }
}
