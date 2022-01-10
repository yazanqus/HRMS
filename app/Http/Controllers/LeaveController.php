<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Leavetype;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leave = Leave::all();
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
        $days = $interval->format('%a');

        // $userid = Auth::user()->id;
        $user = Auth::user();

        $userbalance = $user->balances->vlaue->where('leavetype_id' == $request->leavetype_id);

        dd($userbalance);

        if ($days >= $userbalance) {

        }

        $leave = new Leave();
        $leave->start_date = $request->start_date;
        $leave->end_date = $request->end_date;
        $leave->leavetype_id = $request->leavetype_id;
        $leave->user_id = auth()->user()->id;

        $leave->save();

        // $user = new User();
        // $user->name = $request->name;
        // $user->national_id = $request->national_id;
        // $user->country = $request->country;
        // $user->phone_number = $request->phone_number;
        // $user->save();

        // $reservation = new Reservation();
        // // $reservation->price = $request->price;
        // $reservation->room_id = $request->room_id;
        // $reservation->paid = $request->paid;
        // $reservation->started_at = $request->started_at;
        // $reservation->offer_id = $request->offer_id;
        // $reservation->ended_at = $request->ended_at;
        // $reservation->paid_at = $request->paid_at;
        // $reservation->canceled_at = $request->canceled_at;
        // $reservation->user_id = $user->id;
        // // $reservation->room->status = 'Busy';
        // if ($reservation->offer->type = 'percentage') {
        //     $dis = (1 - (0.01 * $reservation->offer->discount));
        //     $reservation->price = $reservation->room->price * $dis - $reservation->paid;
        // } elseif ($reservation->offer->type = 'const') {
        //     $dis = $reservation->offer->discount * 1;
        //     $reservation->price = $reservation->room->price - $dis - $reservation->paid;
        // }
        // $reservation->save();

        // $reservation->room->update(['status' => 'busy']);
        // if ($reservation->paid != '0') {
        //     $reservation->transactions()->create([
        //         'type' => 'In',
        //         'amount' => $reservation->paid,
        //         'description' => 'paid at Booking',
        //     ]);
        // }

        return redirect()->route('leaves.index');

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
}
