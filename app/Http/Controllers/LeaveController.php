<?php

namespace App\Http\Controllers;

use App\Exports\LeavesExport;
use App\Models\Balance;
use App\Models\Leave;
use App\Models\Leavetype;
use App\Models\User;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Leave as MailLeave;
use App\Mail\Leaveafterlm as MailLeaveafterlm;
use App\Mail\Leavefinal as MailLeavefinal;
use App\Mail\Leaverejected as MailLeaverejected;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;

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
        $variable = '';
        return view('leaves.index', ['leaves' => $leave, 'variable' => $variable]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = Auth::user();
        $leavesIds = [1,13,14,15,16,17];
        if ($user->contract == "Service")
        {
            $leavetypes = Leavetype::whereIn('id', $leavesIds)->get();
            return view('leaves.create', ['leavetypes' => $leavetypes]);

        }

        else
        {
            
            $leavetypes = Leavetype::all();
            return view('leaves.create', ['leavetypes' => $leavetypes]);
        }
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

        //balance of annual half first and second half (13) + (14) is from annual leave (1)
        if ($request->leavetype_id == '13' || $request->leavetype_id == '14') {

            $balances = Balance::where('user_id', $user->id)->get();
            $subsets = $balances->map(function ($balance) {
                return collect($balance->toArray())

                    ->only(['value', 'leavetype_id'])  
                    ->all();
            });
            $final = $subsets->firstwhere('leavetype_id', '1');
            $finalfinal = $final['value'];
            $annualleavebalance = $finalfinal;

        }
        //balance of unpaid half first and second (16) + (17) is from unpaid leave (15)
        elseif ($request->leavetype_id == '16' || $request->leavetype_id == '17') {

            $balances = Balance::where('user_id', $user->id)->get();
            $subsets = $balances->map(function ($balance) {
                return collect($balance->toArray())

                    ->only(['value', 'leavetype_id'])
                    ->all();
            });
            $final = $subsets->firstwhere('leavetype_id', '15');
            $finalfinal = $final['value'];
            $unpaidleavebalance = $finalfinal;

        }

        //balance of comp hour (19) is from comp (18) after multiplying by 8
        elseif ($request->leavetype_id == '19') {

            $balances = Balance::where('user_id', $user->id)->get();
            $subsets = $balances->map(function ($balance) {
                return collect($balance->toArray())

                    ->only(['value', 'leavetype_id'])
                    ->all();
            });
            $final = $subsets->firstwhere('leavetype_id', '18');
            $finalfinal = $final['value'];
            $comphalfleavebalance = $finalfinal * 8;

        } else {
            $balances = Balance::where('user_id', $user->id)->get();
            $subsets = $balances->map(function ($balance) {
                return collect($balance->toArray())

                    ->only(['value', 'leavetype_id'])
                    ->all();
            });
            $final = $subsets->firstwhere('leavetype_id', $request->leavetype_id);
            $finalfinal = $final['value'];
            $currentbalance = $finalfinal;
        }

        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
            'leavetype_id' => 'required',
            'reason',
            'hours',
            'file' => 'nullable|mimes:jpeg,png,jpg,pdf|max:3072',
        ]);

        $hours = $request->hours ;
        
        $fdate = $request->start_date;
        $ldate = $request->end_date;
        // $datetime1 = new DateTime($fdate);
        // $datetime2 = new DateTime($ldate);

        // Applying answer for remooving weekwends
        // $intervalllll = DateInterval::createFromDateString('1 day');
        // $period = new DatePeriod($datetime1, $intervalllll, $datetime2);
        // $busdays = 0;

        // foreach ($period as $day) {
        //     // $day is not friday nor saturday
        //     if (!in_array($day->format('w'), [4, 5])) {
        //         $busdays++;
        //     }
        // }

        $start = new DateTime($fdate);
        $end = new DateTime($ldate);
        // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);

        // total days
        $sickpercentagedays = $interval->days;
        $days = $interval->days;

        // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);

        foreach ($period as $dt) {
            $curr = $dt->format('D');

            // substract if Saturday or Sunday
            if ($curr == 'Sat' || $curr == 'Fri') {
                $days--;
            }

        }

        // $interval = $datetime1->diff($datetime2);
        // $dayss = $interval->format('%a');
        // $days = $dayss+'1';

        $datenow = Carbon::now();
        $joineddate = new DateTime($user->joined_date);
        $dateenow = new DateTime($datenow);
        $intervall = $joineddate->diff($dateenow);
        $probationdays = $intervall->format('%a');

        $startdayname = Carbon::parse($fdate)->format('l');
        $enddayname = Carbon::parse($ldate)->format('l');

  

        // Annual leave conditions
        if ($request->leavetype_id == '1') {

            if ($probationdays >= '90') {

                if ($days <= $currentbalance) {


                    $leavessubmitted = Leave::where([
                        ['user_id', $user->id],
                        ['start_date', $request->start_date],
                        ])->where(function($query) {
                            $query->where('status','Pending LM Approval')
                                        ->orWhere('status','Pending HR Approval')
                                        ->orWhere('status','Approved');
                })->get();

                    $counted = count($leavessubmitted);


                    if($counted > 0)
                    {
                        return redirect()->back()->with("error", "You have already submitted a leave starting this day");
                    }

                    else
                    {                    
                        
                    if ($request->hasFile('file')) {
                        $path = $request->file('file')->store('public/leaves');
                    }

                    $leave = new Leave();
                    $leave->start_date = $request->start_date;
                    $leave->end_date = $request->end_date;
                    $leave->reason = $request->reason;
                    if ($request->hasFile('file')) {
                        $leave->path = $path;
                    }
                    $leave->days = $days;
                    $leave->leavetype_id = $request->leavetype_id;
                    $leave->user_id = auth()->user()->id;
                    if (!isset($user->linemanager)) {
                        $leave->status = 'Pending HR Approval';

                    } else {

                        $leave->status = 'Pending LM Approval';


                        $linemanageremail = User::where('name',$user->linemanager)->value('email');

                        // dd($linemanageremail);
                        $details = [
                            'requestername' => $user->name,
                            'linemanagername' => $user->linemanager,
                            'linemanageremail' => $linemanageremail,
                            'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                            'leavetype' => $leave->leavetype->name,
                            'startdayname' => $startdayname,
                            'start_date' => $leave->start_date,
                            'enddayname' => $enddayname,
                            'end_date' =>  $leave->end_date,
                            'days' => $leave->days,
                            'comment' =>  $leave->reason
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));

                        
                    }

                    $leave->save();
                    return redirect()->route('leaves.index');

                    }
  

                } else {
                    return redirect()->back()->with("error", "Leave remaining balance is not enough");
                }
            } else {
                return redirect()->back()->with("error", "You can't submit leave while still on probation");
            }
        }

        //sick leave
        elseif ($request->leavetype_id == '2') {
            if ($days <= $currentbalance) {

                if ($request->hasFile('file')) {
                    $path = $request->file('file')->store('public/leaves');
                }
                if ($days > '1' and $request->hasFile('file') == null) {
                    return redirect()->back()->with("error", "Attachement is missing");
                }



                $leavessubmitted = Leave::where([
                    ['user_id', $user->id],
                    ['start_date', $request->start_date],
                    ])->where(function($query) {
                        $query->where('status','Pending LM Approval')
                                    ->orWhere('status','Pending HR Approval')
                                    ->orWhere('status','Approved');
            })->get();

                $counted = count($leavessubmitted);


                if($counted > 0)
                {
                    return redirect()->back()->with("error", "You have already submitted a leave starting this day");
                }


                else

                {

                
                $leave = new Leave();
                $leave->start_date = $request->start_date;
                $leave->end_date = $request->end_date;
                $leave->reason = $request->reason;
                if ($request->hasFile('file')) {
                    $leave->path = $path;
                }

                $leave->days = $days;
                $leave->leavetype_id = $request->leavetype_id;
                $leave->user_id = auth()->user()->id;
                if (!isset($user->linemanager)) {
                    $leave->status = 'Pending HR Approval';

                } else {

                    $leave->status = 'Pending LM Approval';
                    $linemanageremail = User::where('name',$user->linemanager)->value('email');

                        // dd($linemanageremail);
                        $details = [
                            'requestername' => $user->name,
                            'linemanagername' => $user->linemanager,
                            'linemanageremail' => $linemanageremail,
                            'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                            'leavetype' => $leave->leavetype->name,
                            'startdayname' => $startdayname,
                            'start_date' => $leave->start_date,
                            'enddayname' => $enddayname,
                            'end_date' =>  $leave->end_date,
                            'days' => $leave->days,
                            'comment' =>  $leave->reason
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                }

                $leave->save();
                // $user->notify(new EmailNotification($leave));

                return redirect()->route('leaves.index');
            }

            } else {
                return redirect()->back()->with("error", "Leave remaining balance is not enough");
            }
        }

        //sick 30 leave
        elseif ($request->leavetype_id == '3') {
            if ($days <= $currentbalance) {

                if ($request->hasFile('file')) {
                    $path = $request->file('file')->store('public/leaves');
                } else {
                    return redirect()->back()->with("error", "Attachement is missing");
                }


                $leavessubmitted = Leave::where([
                    ['user_id', $user->id],
                    ['start_date', $request->start_date],
                    ])->where(function($query) {
                        $query->where('status','Pending LM Approval')
                                    ->orWhere('status','Pending HR Approval')
                                    ->orWhere('status','Approved');
            })->get();

                $counted = count($leavessubmitted);

                if($counted > 0)
                {
                    return redirect()->back()->with("error", "You have already submitted a leave starting this day");
                }


                else
                {

                
                $leave = new Leave();
                $leave->start_date = $request->start_date;
                $leave->end_date = $request->end_date;
                $leave->reason = $request->reason;
                if ($request->hasFile('file')) {
                    $leave->path = $path;
                }

                $leave->days = $sickpercentagedays;
                $leave->leavetype_id = $request->leavetype_id;
                $leave->user_id = auth()->user()->id;
                if (!isset($user->linemanager)) {
                    $leave->status = 'Pending HR Approval';

                } else {

                    $leave->status = 'Pending LM Approval';
                    $linemanageremail = User::where('name',$user->linemanager)->value('email');

                        // dd($linemanageremail);
                        $details = [
                            'requestername' => $user->name,
                            'linemanagername' => $user->linemanager,
                            'linemanageremail' => $linemanageremail,
                            'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                            'leavetype' => $leave->leavetype->name,
                            'startdayname' => $startdayname,
                            'start_date' => $leave->start_date,
                            'enddayname' => $enddayname,
                            'end_date' =>  $leave->end_date,
                            'days' => $leave->days,
                            'comment' =>  $leave->reason
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                }

                $leave->save();
                // $user->notify(new EmailNotification($leave));

                return redirect()->route('leaves.index');

            }

            } else {
                return redirect()->back()->with("error", "Leave remaining balance is not enough");
            }
        }

        //sick 20 leave
        elseif ($request->leavetype_id == '4') {
            if ($days <= $currentbalance) {

                if ($request->hasFile('file')) {
                    $path = $request->file('file')->store('public/leaves');
                } else {
                    return redirect()->back()->with("error", "Attachement is missing");
                }

                $leavessubmitted = Leave::where([
                    ['user_id', $user->id],
                    ['start_date', $request->start_date],
                    ])->where(function($query) {
                        $query->where('status','Pending LM Approval')
                                    ->orWhere('status','Pending HR Approval')
                                    ->orWhere('status','Approved');
            })->get();

                $counted = count($leavessubmitted);


                if($counted > 0)
                {
                    return redirect()->back()->with("error", "You have already submitted a leave starting this day");
                }


                else
                {

                
                $leave = new Leave();
                $leave->start_date = $request->start_date;
                $leave->end_date = $request->end_date;
                $leave->reason = $request->reason;
                if ($request->hasFile('file')) {
                    $leave->path = $path;
                }

                $leave->days = $sickpercentagedays;
                $leave->leavetype_id = $request->leavetype_id;
                $leave->user_id = auth()->user()->id;
                if (!isset($user->linemanager)) {
                    $leave->status = 'Pending HR Approval';

                } else {

                    $leave->status = 'Pending LM Approval';
                    $linemanageremail = User::where('name',$user->linemanager)->value('email');

                        // dd($linemanageremail);
                        $details = [
                            'requestername' => $user->name,
                            'linemanagername' => $user->linemanager,
                            'linemanageremail' => $linemanageremail,
                            'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                            'leavetype' => $leave->leavetype->name,
                            'startdayname' => $startdayname,
                            'start_date' => $leave->start_date,
                            'enddayname' => $enddayname,
                            'end_date' =>  $leave->end_date,
                            'days' => $leave->days,
                            'comment' =>  $leave->reason
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                }

                $leave->save();
                // $user->notify(new EmailNotification($leave));

                return redirect()->route('leaves.index');

            }
            } else {
                return redirect()->back()->with("error", "Leave remaining balance is not enough");
            }
        }

        // Marriage leave conditions
        elseif ($request->leavetype_id == '5') {

            if ($probationdays >= '180') {

                if ($days <= $currentbalance) {

                    if ($request->hasFile('file')) {
                        $path = $request->file('file')->store('public/leaves');
                    }


                    $leavessubmitted = Leave::where([
                        ['user_id', $user->id],
                        ['start_date', $request->start_date],
                        ])->where(function($query) {
                            $query->where('status','Pending LM Approval')
                                        ->orWhere('status','Pending HR Approval')
                                        ->orWhere('status','Approved');
                })->get();
    
                    $counted = count($leavessubmitted);
    
    
                    if($counted > 0)
                    {
                        return redirect()->back()->with("error", "You have already submitted a leave starting this day");
                    }

                    else

                    {

                    
                    $leave = new Leave();
                    $leave->start_date = $request->start_date;
                    $leave->end_date = $request->end_date;
                    $leave->reason = $request->reason;
                    if ($request->hasFile('file')) {
                        $leave->path = $path;
                    }

                    $leave->days = $days;
                    $leave->leavetype_id = $request->leavetype_id;
                    $leave->user_id = auth()->user()->id;
                    if (!isset($user->linemanager)) {
                        $leave->status = 'Pending HR Approval';

                    } else {

                        $leave->status = 'Pending LM Approval';
                        $linemanageremail = User::where('name',$user->linemanager)->value('email');

                        // dd($linemanageremail);
                        $details = [
                            'requestername' => $user->name,
                            'linemanagername' => $user->linemanager,
                            'linemanageremail' => $linemanageremail,
                            'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                            'leavetype' => $leave->leavetype->name,
                            'startdayname' => $startdayname,
                            'start_date' => $leave->start_date,
                            'enddayname' => $enddayname,
                            'end_date' =>  $leave->end_date,
                            'days' => $leave->days,
                            'comment' =>  $leave->reason
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                    }

                    $leave->save();

                    return redirect()->route('leaves.index');

                    }
                } else {
                    return redirect()->back()->with("error", "Leave remaining balance is not enough");
                }
            } else {
                return redirect()->back()->with("error", "You can't submit leave before at least 6 months of service");
            }

        }

        // Maternity leave coditions
        elseif ($request->leavetype_id == '8') {

            if ($probationdays >= '180') {

                if ($days <= $currentbalance) {

                    if ($request->hasFile('file')) {
                        $path = $request->file('file')->store('public/leaves');
                    }


                    $leavessubmitted = Leave::where([
                        ['user_id', $user->id],
                        ['start_date', $request->start_date],
                        ])->where(function($query) {
                            $query->where('status','Pending LM Approval')
                                        ->orWhere('status','Pending HR Approval')
                                        ->orWhere('status','Approved');
                })->get();
    
                    $counted = count($leavessubmitted);
    
    
                    if($counted > 0)
                    {
                        return redirect()->back()->with("error", "You have already submitted a leave starting this day");
                    }



                    else

                    {
                    


                    $leave = new Leave();
                    $leave->start_date = $request->start_date;
                    $leave->end_date = $request->end_date;
                    $leave->reason = $request->reason;
                    if ($request->hasFile('file')) {
                        $leave->path = $path;
                    }

                    $leave->days = $days;
                    $leave->leavetype_id = $request->leavetype_id;
                    $leave->user_id = auth()->user()->id;
                    if (!isset($user->linemanager)) {
                        $leave->status = 'Pending HR Approval';

                    } else {

                        $leave->status = 'Pending LM Approval';
                        $linemanageremail = User::where('name',$user->linemanager)->value('email');

                        // dd($linemanageremail);
                        $details = [
                            'requestername' => $user->name,
                            'linemanagername' => $user->linemanager,
                            'linemanageremail' => $linemanageremail,
                            'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                            'leavetype' => $leave->leavetype->name,
                            'startdayname' => $startdayname,
                            'start_date' => $leave->start_date,
                            'enddayname' => $enddayname,
                            'end_date' =>  $leave->end_date,
                            'days' => $leave->days,
                            'comment' =>  $leave->reason
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                    }

                    $leave->save();

                    return redirect()->route('leaves.index');
                }
                } else {
                    return redirect()->back()->with("error", "Leave remaining balance is not enough");
                }
            } else {
                return redirect()->back()->with("error", "You can't submit leave before at least 6 months of service");
            }
        }

        // islamic leave coditions
        elseif ($request->leavetype_id == '10') {

            if ($probationdays >= '1825') {

                if ($days <= $currentbalance) {

                    if ($request->hasFile('file')) {
                        $path = $request->file('file')->store('public/leaves');
                    }


                    $leavessubmitted = Leave::where([
                        ['user_id', $user->id],
                        ['start_date', $request->start_date],
                        ])->where(function($query) {
                            $query->where('status','Pending LM Approval')
                                        ->orWhere('status','Pending HR Approval')
                                        ->orWhere('status','Approved');
                })->get();
    
                    $counted = count($leavessubmitted);
    
    
                    if($counted > 0)
                    {
                        return redirect()->back()->with("error", "You have already submitted a leave starting this day");
                    }


                    else

                    {


                    
                    $leave = new Leave();
                    $leave->start_date = $request->start_date;
                    $leave->end_date = $request->end_date;
                    $leave->reason = $request->reason;
                    if ($request->hasFile('file')) {
                        $leave->path = $path;
                    }

                    $leave->days = $days;
                    $leave->leavetype_id = $request->leavetype_id;
                    $leave->user_id = auth()->user()->id;
                    if (!isset($user->linemanager)) {
                        $leave->status = 'Pending HR Approval';

                    } else {

                        $leave->status = 'Pending LM Approval';
                    }

                    $leave->save();

                    return redirect()->route('leaves.index');
                }
                } else {
                    return redirect()->back()->with("error", "Leave remaining balance is not enough");
                }
            } else {
                return redirect()->back()->with("error", "You can't submit leave before at least 5 years of service");
            }
        }

        // christ leave coditions
        elseif ($request->leavetype_id == '11') {

            if ($probationdays >= '1825') {

                if ($days <= $currentbalance) {

                    if ($request->hasFile('file')) {
                        $path = $request->file('file')->store('public/leaves');
                    }




                    
                    $leavessubmitted = Leave::where([
                        ['user_id', $user->id],
                        ['start_date', $request->start_date],
                        ])->where(function($query) {
                            $query->where('status','Pending LM Approval')
                                        ->orWhere('status','Pending HR Approval')
                                        ->orWhere('status','Approved');
                })->get();
    
                    $counted = count($leavessubmitted);
    
    
                    if($counted > 0)
                    {
                        return redirect()->back()->with("error", "You have already submitted a leave starting this day");
                    }

                    else

                    {


                    
                    $leave = new Leave();
                    $leave->start_date = $request->start_date;
                    $leave->end_date = $request->end_date;
                    $leave->reason = $request->reason;
                    if ($request->hasFile('file')) {
                        $leave->path = $path;
                    }

                    $leave->days = $days;
                    $leave->leavetype_id = $request->leavetype_id;
                    $leave->user_id = auth()->user()->id;
                    if (!isset($user->linemanager)) {
                        $leave->status = 'Pending HR Approval';

                    } else {

                        $leave->status = 'Pending LM Approval';
                    }

                    $leave->save();

                    return redirect()->route('leaves.index');

                }
                } else {
                    return redirect()->back()->with("error", "Leave remaining balance is not enough");
                }
            } else {
                return redirect()->back()->with("error", "You can't submit leave before at least 5 years of service");
            }
        }

        // welfare leave coditions
        elseif ($request->leavetype_id == '12') {

            if ($days <= $currentbalance) {
                if ($days <= '3') {

                    if ($request->hasFile('file')) {
                        $path = $request->file('file')->store('public/leaves');
                    }


                    $leavessubmitted = Leave::where([
                        ['user_id', $user->id],
                        ['start_date', $request->start_date],
                        ])->where(function($query) {
                            $query->where('status','Pending LM Approval')
                                        ->orWhere('status','Pending HR Approval')
                                        ->orWhere('status','Approved');
                })->get();
    
                    $counted = count($leavessubmitted);
    
    
                    if($counted > 0)
                    {
                        return redirect()->back()->with("error", "You have already submitted a leave starting this day");
                    }

                    else

                    {


                    
                    $leave = new Leave();
                    $leave->start_date = $request->start_date;
                    $leave->end_date = $request->end_date;
                    $leave->reason = $request->reason;
                    if ($request->hasFile('file')) {
                        $leave->path = $path;
                    }

                    $leave->days = $days;
                    $leave->leavetype_id = $request->leavetype_id;
                    $leave->user_id = auth()->user()->id;
                    if (!isset($user->linemanager)) {
                        $leave->status = 'Pending HR Approval';

                    } else {

                        $leave->status = 'Pending LM Approval';
                        $linemanageremail = User::where('name',$user->linemanager)->value('email');

                        // dd($linemanageremail);
                        $details = [
                            'requestername' => $user->name,
                            'linemanagername' => $user->linemanager,
                            'linemanageremail' => $linemanageremail,
                            'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                            'leavetype' => $leave->leavetype->name,
                            'startdayname' => $startdayname,
                            'start_date' => $leave->start_date,
                            'enddayname' => $enddayname,
                            'end_date' =>  $leave->end_date,
                            'days' => $leave->days,
                            'comment' =>  $leave->reason
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                    }

                    $leave->save();

                    return redirect()->route('leaves.index');
                }

                } else {
                    return redirect()->back()->with("error", "Can't submit more than 3 days welfare per week");
                }
            } else {
                return redirect()->back()->with("error", "Leave remaining balance is not enough");
            }

        }

        // Annual leave halfday coditions
        elseif ($request->leavetype_id == '13' || $request->leavetype_id == '14') {

            if ($probationdays >= '90') {

                if ($annualleavebalance >= '0.5') {

                    if ($request->hasFile('file')) {
                        $path = $request->file('file')->store('public/leaves');
                    }


                    $leavessubmitted = Leave::where([
                        ['user_id', $user->id],
                        ['leavetype_id', $request->leavetype_id],
                        ['start_date', $request->start_date],
                        ])->where(function($query) {
                            $query->where('status','Pending LM Approval')
                                        ->orWhere('status','Pending HR Approval')
                                        ->orWhere('status','Approved');
                })->get();
    
                    $counted = count($leavessubmitted);
    
    
                    if($counted > 0)
                    {
                        return redirect()->back()->with("error", "You have already submitted a leave starting this day");
                    }

                    else

                    {


                    

                    $leave = new Leave();
                    $leave->start_date = $request->start_date;
                    $leave->end_date = $request->end_date;
                    $leave->reason = $request->reason;
                    if ($request->hasFile('file')) {
                        $leave->path = $path;
                    }

                    $leave->days = '0.5';
                    $leave->leavetype_id = $request->leavetype_id;
                    $leave->user_id = auth()->user()->id;
                    if (!isset($user->linemanager)) {
                        $leave->status = 'Pending HR Approval';

                    } else {

                        $leave->status = 'Pending LM Approval';

                        $linemanageremail = User::where('name',$user->linemanager)->value('email');

                        // dd($linemanageremail);
                        $details = [
                            'requestername' => $user->name,
                            'linemanagername' => $user->linemanager,
                            'linemanageremail' => $linemanageremail,
                            'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                            'leavetype' => $leave->leavetype->name,
                            'startdayname' => $startdayname,
                            'start_date' => $leave->start_date,
                            'enddayname' => $enddayname,
                            'end_date' =>  $leave->end_date,
                            'days' => $leave->days,
                            'comment' =>  $leave->reason
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                    }

                    $leave->save();

                    return redirect()->route('leaves.index');

                }
                } else {
                    return redirect()->back()->with("error", "Leave remaining balance is not enough");
                }
            } else {
                return redirect()->back()->with("error", "You can't submit leave while still on probation");
            }
        }

        // comp leave hours coditions
        elseif ($request->leavetype_id == '19') {

            
            if ($hours <= $comphalfleavebalance) {

                if ($request->hasFile('file')) {
                    $path = $request->file('file')->store('public/leaves');
                }
                $leave = new Leave();
                $leave->start_date = $request->start_date;
                $leave->end_date = $request->end_date;
                $leave->reason = $request->reason;
                if ($request->hasFile('file')) {
                    $leave->path = $path;
                }

                $leave->hours = $hours;
                $leave->leavetype_id = $request->leavetype_id;
                $leave->user_id = auth()->user()->id;
                if (!isset($user->linemanager)) {
                    $leave->status = 'Pending HR Approval';

                } else {

                    $leave->status = 'Pending LM Approval';
                    $linemanageremail = User::where('name',$user->linemanager)->value('email');

                        // dd($linemanageremail);
                        $details = [
                            'requestername' => $user->name,
                            'linemanagername' => $user->linemanager,
                            'linemanageremail' => $linemanageremail,
                            'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                            'leavetype' => $leave->leavetype->name,
                            'startdayname' => $startdayname,
                            'start_date' => $leave->start_date,
                            'enddayname' => $enddayname,
                            'end_date' =>  $leave->end_date,
                            'days' => $leave->days,
                            'comment' =>  $leave->reason
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                }

                $leave->save();

                return redirect()->route('leaves.index');
            } else {
                return redirect()->back()->with("error", "Leave remaining balance is not enough");
            }

        }
//compensation full day
        elseif ($request->leavetype_id == '18') {

            // $days <= $currentbalance

            if ($days <= $currentbalance) {

                if ($request->hasFile('file')) {
                    $path = $request->file('file')->store('public/leaves');
                }

                $leavessubmitted = Leave::where([
                    ['user_id', $user->id],
                    ['start_date', $request->start_date],
                    ])->where(function($query) {
                        $query->where('status','Pending LM Approval')
                                    ->orWhere('status','Pending HR Approval')
                                    ->orWhere('status','Approved');
            })->get();

                $counted = count($leavessubmitted);


                if($counted > 0)
                {
                    return redirect()->back()->with("error", "You have already submitted a leave starting this day");
                }


                else

                {


                
                $leave = new Leave();
                $leave->start_date = $request->start_date;
                $leave->end_date = $request->end_date;
                $leave->reason = $request->reason;
                if ($request->hasFile('file')) {
                    $leave->path = $path;
                }

                $leave->days = $days;
                $leave->leavetype_id = $request->leavetype_id;
                $leave->user_id = auth()->user()->id;
                if (!isset($user->linemanager)) {
                    $leave->status = 'Pending HR Approval';

                } else {

                    $leave->status = 'Pending LM Approval';
                    $linemanageremail = User::where('name',$user->linemanager)->value('email');

                        // dd($linemanageremail);
                        $details = [
                            'requestername' => $user->name,
                            'linemanagername' => $user->linemanager,
                            'linemanageremail' => $linemanageremail,
                            'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                            'leavetype' => $leave->leavetype->name,
                            'startdayname' => $startdayname,
                            'start_date' => $leave->start_date,
                            'enddayname' => $enddayname,
                            'end_date' =>  $leave->end_date,
                            'days' => $leave->days,
                            'comment' =>  $leave->reason
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                }

                $leave->save();

                return redirect()->route('leaves.index');
            }
            } else {
                return redirect()->back()->with("error", "Leave remaining balance is not enough");
            }

        }

        // Paternity leave coditions
        elseif ($request->leavetype_id == '9') {

            if ($probationdays >= '180') {

                if ($days <= $currentbalance) {

                    if ($request->hasFile('file')) {
                        $path = $request->file('file')->store('public/leaves');
                    }

                    $leavessubmitted = Leave::where([
                        ['user_id', $user->id],
                        ['start_date', $request->start_date],
                        ])->where(function($query) {
                            $query->where('status','Pending LM Approval')
                                        ->orWhere('status','Pending HR Approval')
                                        ->orWhere('status','Approved');
                })->get();
    
                    $counted = count($leavessubmitted);
    
    
                    if($counted > 0)
                    {
                        return redirect()->back()->with("error", "You have already submitted a leave starting this day");
                    }

                    else
                    {


                  
                    $leave = new Leave();
                    $leave->start_date = $request->start_date;
                    $leave->end_date = $request->end_date;
                    $leave->reason = $request->reason;
                    if ($request->hasFile('file')) {
                        $leave->path = $path;
                    }

                    $leave->days = $days;
                    $leave->leavetype_id = $request->leavetype_id;
                    $leave->user_id = auth()->user()->id;
                    if (!isset($user->linemanager)) {
                        $leave->status = 'Pending HR Approval';

                    } else {

                        $leave->status = 'Pending LM Approval';

                        $linemanageremail = User::where('name',$user->linemanager)->value('email');

                        // dd($linemanageremail);
                        $details = [
                            'requestername' => $user->name,
                            'linemanagername' => $user->linemanager,
                            'linemanageremail' => $linemanageremail,
                            'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                            'leavetype' => $leave->leavetype->name,
                            'startdayname' => $startdayname,
                            'start_date' => $leave->start_date,
                            'enddayname' => $enddayname,
                            'end_date' =>  $leave->end_date,
                            'days' => $leave->days,
                            'comment' =>  $leave->reason
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                    }

                    $leave->save();

                    return redirect()->route('leaves.index');

                }
                } else {
                    return redirect()->back()->with("error", "Leave remaining balance is not enough");
                }
            } else {
                return redirect()->back()->with("error", "You can't submit leave before at least 6 months of service");
            }

        }

        //unpaid halfday
        elseif ($request->leavetype_id == '16' || $request->leavetype_id == '17') {

            if ($probationdays >= '90') {

                if ($unpaidleavebalance >= '0.5') {

                    if ($request->hasFile('file')) {
                        $path = $request->file('file')->store('public/leaves');
                    }

                    $leavessubmitted = Leave::where([
                        ['user_id', $user->id],
                        ['leavetype_id', $request->leavetype_id],
                        ['start_date', $request->start_date],
                        ])->where(function($query) {
                            $query->where('status','Pending LM Approval')
                                        ->orWhere('status','Pending HR Approval')
                                        ->orWhere('status','Approved');
                })->get();
    
                    $counted = count($leavessubmitted);
    
    
                    if($counted > 0)
                    {
                        return redirect()->back()->with("error", "You have already submitted a leave starting this day");
                    }

                    else
                    {


                    
                    $leave = new Leave();
                    $leave->start_date = $request->start_date;
                    $leave->end_date = $request->end_date;
                    $leave->reason = $request->reason;
                    if ($request->hasFile('file')) {
                        $leave->path = $path;
                    }

                    $leave->days = '0.5';
                    $leave->leavetype_id = $request->leavetype_id;
                    $leave->user_id = auth()->user()->id;
                    if (!isset($user->linemanager)) {
                        $leave->status = 'Pending HR Approval';

                    } else {

                        $leave->status = 'Pending LM Approval';

                        $linemanageremail = User::where('name',$user->linemanager)->value('email');

                        // dd($linemanageremail);
                        $details = [
                            'requestername' => $user->name,
                            'linemanagername' => $user->linemanager,
                            'linemanageremail' => $linemanageremail,
                            'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                            'leavetype' => $leave->leavetype->name,
                            'startdayname' => $startdayname,
                            'start_date' => $leave->start_date,
                            'enddayname' => $enddayname,
                            'end_date' =>  $leave->end_date,
                            'days' => $leave->days,
                            'comment' =>  $leave->reason
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                    }

                    $leave->save();

                    return redirect()->route('leaves.index');

                }
                } else {
                    return redirect()->back()->with("error", "Leave remaining balance is not enough");
                }
            } else {
                return redirect()->back()->with("error", "You can't submit leave while still on probation");
            }
        }

        //first degree days should be less than 5 days
        elseif ($request->leavetype_id == '6') {

            if ($days <= '5') {

                if ($request->hasFile('file')) {
                    $path = $request->file('file')->store('public/leaves');
                }


                
                $leavessubmitted = Leave::where([
                    ['user_id', $user->id],
                    ['start_date', $request->start_date],
                    ])->where(function($query) {
                        $query->where('status','Pending LM Approval')
                                    ->orWhere('status','Pending HR Approval')
                                    ->orWhere('status','Approved');
            })->get();

                $counted = count($leavessubmitted);


                if($counted > 0)
                {
                    return redirect()->back()->with("error", "You have already submitted a leave starting this day");
                }


                else

                {


                

                $leave = new Leave();
                $leave->start_date = $request->start_date;
                $leave->end_date = $request->end_date;
                $leave->reason = $request->reason;
                if ($request->hasFile('file')) {
                    $leave->path = $path;
                }

                $leave->days = $days;
                $leave->leavetype_id = $request->leavetype_id;
                $leave->user_id = auth()->user()->id;
                if (!isset($user->linemanager)) {
                    $leave->status = 'Pending HR Approval';

                } else {

                    $leave->status = 'Pending LM Approval';

                    $linemanageremail = User::where('name',$user->linemanager)->value('email');

                        // dd($linemanageremail);
                        $details = [
                            'requestername' => $user->name,
                            'linemanagername' => $user->linemanager,
                            'linemanageremail' => $linemanageremail,
                            'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                            'leavetype' => $leave->leavetype->name,
                            'startdayname' => $startdayname,
                            'start_date' => $leave->start_date,
                            'enddayname' => $enddayname,
                            'end_date' =>  $leave->end_date,
                            'days' => $leave->days,
                            'comment' =>  $leave->reason
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                }

                $leave->save();

                return redirect()->route('leaves.index');
            }
            } else {
                return redirect()->back()->with("error", "Can't submit more than 5 days leave of this type per request");
            }

        }

        //second degree days should be less than 3 days
        elseif ($request->leavetype_id == '7') {

            if ($days <= '3') {

                if ($request->hasFile('file')) {
                    $path = $request->file('file')->store('public/leaves');
                }


                $leavessubmitted = Leave::where([
                    ['user_id', $user->id],
                    ['start_date', $request->start_date],
                    ])->where(function($query) {
                        $query->where('status','Pending LM Approval')
                                    ->orWhere('status','Pending HR Approval')
                                    ->orWhere('status','Approved');
            })->get();

                $counted = count($leavessubmitted);


                if($counted > 0)
                {
                    return redirect()->back()->with("error", "You have already submitted a leave starting this day");
                }
                

                else
                {


                
                $leave = new Leave();
                $leave->start_date = $request->start_date;
                $leave->end_date = $request->end_date;
                $leave->reason = $request->reason;
                if ($request->hasFile('file')) {
                    $leave->path = $path;
                }

                $leave->days = $days;
                $leave->leavetype_id = $request->leavetype_id;
                $leave->user_id = auth()->user()->id;
                if (!isset($user->linemanager)) {
                    $leave->status = 'Pending HR Approval';

                } else {

                    $leave->status = 'Pending LM Approval';

                    $linemanageremail = User::where('name',$user->linemanager)->value('email');

                        // dd($linemanageremail);
                        $details = [
                            'requestername' => $user->name,
                            'linemanagername' => $user->linemanager,
                            'linemanageremail' => $linemanageremail,
                            'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                            'leavetype' => $leave->leavetype->name,
                            'startdayname' => $startdayname,
                            'start_date' => $leave->start_date,
                            'enddayname' => $enddayname,
                            'end_date' =>  $leave->end_date,
                            'days' => $leave->days,
                            'comment' =>  $leave->reason
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                }

                $leave->save();

                return redirect()->route('leaves.index');
            }
            } else {
                return redirect()->back()->with("error", "Can't submit more than 3 days leave of this type per request");
            }

        } else {
            if ($request->hasFile('file')) {
                $path = $request->file('file')->store('public/leaves');
            }

            
            $leavessubmitted = Leave::where([
                ['user_id', $user->id],
                ['start_date', $request->start_date],
                ])->where(function($query) {
                    $query->where('status','Pending LM Approval')
                                ->orWhere('status','Pending HR Approval')
                                ->orWhere('status','Approved');
        })->get();

            $counted = count($leavessubmitted);


            if($counted > 0)
            {
                return redirect()->back()->with("error", "You have already submitted a leave on this day");
            }

            else
            {

            

            $leave = new Leave();
            $leave->start_date = $request->start_date;
            $leave->end_date = $request->end_date;
            $leave->reason = $request->reason;
            if ($request->hasFile('file')) {
                $leave->path = $path;
            }
            $leave->days = $days;
            $leave->leavetype_id = $request->leavetype_id;
            $leave->user_id = auth()->user()->id;
            if (!isset($user->linemanager)) {
                $leave->status = 'Pending HR Approval';

            } else {

                $leave->status = 'Pending LM Approval';

                $linemanageremail = User::where('name',$user->linemanager)->value('email');

                        // dd($linemanageremail);
                        $details = [
                            'requestername' => $user->name,
                            'linemanagername' => $user->linemanager,
                            'linemanageremail' => $linemanageremail,
                            'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                            'leavetype' => $leave->leavetype->name,
                            'startdayname' => $startdayname,
                            'start_date' => $leave->start_date,
                            'enddayname' => $enddayname,
                            'end_date' =>  $leave->end_date,
                            'days' => $leave->days,
                            'comment' =>  $leave->reason
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
            }

            $leave->save();

            // $data = ['foo' => 'baz'];

            // Mail::send('danial@admin.com', $data, function ($message) use ($user)
            //     $message->to('danial@admin.com');
            //     $message->subject('Welcome Mail');
            // });

            return redirect()->route('leaves.index');
        }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show($leaveid)
    {
        $id = decrypt($leaveid);
        // dd($id);
        $leave = Leave::findOrFail($id);
        // $leavetype = Leavetype::where('id', $leave-)->get();
        return view('leaves.show', ['leave' => $leave]);
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
    public function destroy($id)
    {
        $leave = Leave::find($id);
        if (isset($leave->path)) {
            $file_path = public_path() . '/storage/leaves/' . basename($leave->path);
            unlink($file_path);
        }

        $leave->delete();
        return redirect()->route('leaves.index')->with("success", "Leave is canceled");
    }

    public function approved($id)
    {
        $lmuser = Auth::user();
        $leave = Leave::find($id);
        $leave->status = 'Pending HR Approval';
        $leave->lmapprover = $lmuser->name;

        $startdayname = Carbon::parse($leave->start_date)->format('l');
        $enddayname = Carbon::parse($leave->end_date)->format('l');


        $requester=$leave->user;
        // $linemanageremail = User::where('name',$requester->linemanager)->value('email');

        // dd($linemanageremail);
        $details = [
            'requestername' => $requester->name,
            'linemanagername' => $requester->linemanager,
            // 'linemanageremail' => $linemanageremail,
            'title' => 'Leave Request - '.$leave->leavetype->name. ' - Approved by Line Manager',
            'startdayname' => $startdayname,
            'start_date' => $leave->start_date,
            'enddayname' => $enddayname,
            'end_date' =>  $leave->end_date,
            'days' => $leave->days,
            'status' => $leave->status,
            'comment' =>  $leave->reason
        ];
       
        Mail::to($requester->email)->send(new MailLeaveafterlm($details));

        $leave->save();

        return redirect()->route('leaves.approval');

    }

    public function declined($id)
    {
        $lmuser = Auth::user();
        $leave = Leave::find($id);
        $leave->status = 'Declined by LM';
        $leave->lmapprover = $lmuser->name;
        $startdayname = Carbon::parse($leave->start_date)->format('l');
        $enddayname = Carbon::parse($leave->end_date)->format('l');


        $requester=$leave->user;
        // $linemanageremail = User::where('name',$requester->linemanager)->value('email');

        // dd($linemanageremail);
        $details = [
            'requestername' => $requester->name,
            'linemanagername' => $requester->linemanager,
            // 'linemanageremail' => $linemanageremail,
            'title' => 'Leave Request - '.$leave->leavetype->name. ' - Declined by Line Manager',
            'startdayname' => $startdayname,
            'start_date' => $leave->start_date,
            'enddayname' => $enddayname,
            'end_date' =>  $leave->end_date,
            'days' => $leave->days,
            'status' => $leave->status,
            'comment' =>  $leave->reason
        ];
       
        Mail::to($requester->email)->send(new MailLeaveafterlm($details));
        
        $leave->save();

        return redirect()->route('leaves.approval');

    }

    public function hrapproved($id)
    {
        $hruser = Auth::user();
        $leave = Leave::find($id);

                // annual half days leaves
                if ($leave->leavetype_id == '13' || $leave->leavetype_id == '14') {

                    $balances = Balance::where('user_id', $leave->user->id)->get();
                    $subsets = $balances->map(function ($balance) {
                        return collect($balance->toArray())
        
                            ->only(['value', 'leavetype_id'])
                            ->all();
                    });
                    $final = $subsets->firstwhere('leavetype_id', '1');
        
                    $finalfinal = $final['value'];
                    $currentbalanceforannual = $finalfinal;
        
                    $newbalance = $currentbalanceforannual - $leave->days;
        
         
        
                    // unpaid half days leaves
                } elseif ($leave->leavetype_id == '16' || $leave->leavetype_id == '17') {
        
                    $balances = Balance::where('user_id', $leave->user->id)->get();
                    $subsets = $balances->map(function ($balance) {
                        return collect($balance->toArray())
        
                            ->only(['value', 'leavetype_id'])
                            ->all();
                    });
                    $final = $subsets->firstwhere('leavetype_id', '15');
        
                    $finalfinal = $final['value'];
                    $currentbalanceforunpaid = $finalfinal;
        
                    $newbalance = $currentbalanceforunpaid - $leave->days;
        

        
                    
        //comp hour
                } elseif ($leave->leavetype_id == '19') {
        
                    $balances = Balance::where('user_id', $leave->user->id)->get();
                    $subsets = $balances->map(function ($balance) {
                        return collect($balance->toArray())
        
                            ->only(['value', 'leavetype_id'])
                            ->all();
                    });
                    $final = $subsets->firstwhere('leavetype_id', '18');
        
                    $finalfinal = $final['value'];
                    $currentbalanceforcomp = $finalfinal;
        
                    $newbalance = $currentbalanceforcomp - ($leave->hours / 8);
        

                } else {
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
        

                }


                if($newbalance < 0)
                {
                    return redirect()->back()->with("error", "No enough balance for this type, you can only decline the leave");
                }

                else
                {
                    $leave->status = 'Approved';
                    $leave->hrapprover = $hruser->name;
            
                    $startdayname = Carbon::parse($leave->start_date)->format('l');
                    $enddayname = Carbon::parse($leave->end_date)->format('l');
                    
                    $requester=$leave->user;

                    $details = [
                        'requestername' => $requester->name,
                        'linemanagername' => $requester->linemanager,
                        'hrname' => $leave->hrapprover,
                        'title' => 'Leave Request - '.$leave->leavetype->name. ' - Approved by HR',
                        'startdayname' => $startdayname,
                        'start_date' => $leave->start_date,
                        'enddayname' => $enddayname,
                        'end_date' =>  $leave->end_date,
                        'days' => $leave->days,
                        'status' => $leave->status,
                        'comment' =>  $leave->reason,
                        'newbalance' => $newbalance
                    ];
                   
                    Mail::to($requester->email)->send(new MailLeavefinal($details));
            
                    $leave->save();
            
                    // annual half days leaves
                    if ($leave->leavetype_id == '13' || $leave->leavetype_id == '14') {
            
                        $balances = Balance::where('user_id', $leave->user->id)->get();
                        $subsets = $balances->map(function ($balance) {
                            return collect($balance->toArray())
            
                                ->only(['value', 'leavetype_id'])
                                ->all();
                        });
                        $final = $subsets->firstwhere('leavetype_id', '1');
            
                        $finalfinal = $final['value'];
                        $currentbalanceforannual = $finalfinal;
            
                        $newbalance = $currentbalanceforannual - $leave->days;
            
                        Balance::where([
                            ['user_id', $leave->user->id],
                            ['leavetype_id', '1'],
                        ])->update(['value' => $newbalance]);
            
                        // unpaid half days leaves
                    } elseif ($leave->leavetype_id == '16' || $leave->leavetype_id == '17') {
            
                        $balances = Balance::where('user_id', $leave->user->id)->get();
                        $subsets = $balances->map(function ($balance) {
                            return collect($balance->toArray())
            
                                ->only(['value', 'leavetype_id'])
                                ->all();
                        });
                        $final = $subsets->firstwhere('leavetype_id', '15');
            
                        $finalfinal = $final['value'];
                        $currentbalanceforannual = $finalfinal;
            
                        $newbalance = $currentbalanceforannual - $leave->days;
            
                        Balance::where([
                            ['user_id', $leave->user->id],
                            ['leavetype_id', '15'],
                        ])->update(['value' => $newbalance]);
            
                        
            
                    } elseif ($leave->leavetype_id == '19') {
            
                        $balances = Balance::where('user_id', $leave->user->id)->get();
                        $subsets = $balances->map(function ($balance) {
                            return collect($balance->toArray())
            
                                ->only(['value', 'leavetype_id'])
                                ->all();
                        });
                        $final = $subsets->firstwhere('leavetype_id', '18');
            
                        $finalfinal = $final['value'];
                        $currentbalanceforannual = $finalfinal;
            
                        $newbalance = $currentbalanceforannual - ($leave->hours / 8);
            
                        Balance::where([
                            ['user_id', $leave->user->id],
                            ['leavetype_id', '18'],
                        ])->update(['value' => $newbalance]);
                    } else {
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
                    }
            
                    return redirect()->route('leaves.hrapproval');
                }

        

    }

    public function hrdeclined($id)
    {
        $hruser = Auth::user();
        $leave = Leave::find($id);
        $leave->status = 'Declined by HR';
        $leave->hrapprover = $hruser->name;


        $startdayname = Carbon::parse($leave->start_date)->format('l');
        $enddayname = Carbon::parse($leave->end_date)->format('l');
        
        $requester=$leave->user;

        $details = [
            'requestername' => $requester->name,
            'linemanagername' => $requester->linemanager,
            'hrname' => $leave->hrapprover,
            'title' => 'Leave Request - '.$leave->leavetype->name. ' - Declined by HR',
            'startdayname' => $startdayname,
            'start_date' => $leave->start_date,
            'enddayname' => $enddayname,
            'end_date' =>  $leave->end_date,
            'days' => $leave->days,
            'status' => $leave->status,
            'comment' =>  $leave->reason,
        ];
       
        Mail::to($requester->email)->send(new MailLeaverejected($details));


        $leave->save();

        return redirect()->route('leaves.hrapproval');

    }

    public function export()
    {
        return Excel::download(new LeavesExport, 'leaves.xlsx');
    }

    public function pdf(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
            // 'leavetype' => 'required',
            'name'=> 'required',
           
        ]);

        $name= $request->name;
        $start_date=$request->start_date;
        $end_date=$request->end_date;
        // $leavetype=$request->leavetype;

        
        $userid = User::where('name',$name)->value('id');
        
  
 
        $leaves = Leave::where([

            ['user_id', $userid],
            ['start_date', '>=', $start_date],
            ['end_date', '<=', $end_date],


        ])->get();


        $hruser = Auth::user();
        $date = Carbon::now();

        

        $pdf = Pdf::loadView('admin.allstaffleaves.report', ['name'=>$name,'hruser'=>$hruser,'date'=>$date, 'start_date'=>$start_date,'end_date'=>$end_date,'leaves'=>$leaves])->setOptions(['defaultFont' => 'sans-serif', 'isHtml5ParserEnabled'=> 'true', 'isRemoteEnabled'=> 'true', 'isPhpEnabled'=> 'true'])->setpaper('a4','portrait');
        return $pdf->stream();


    }

    // public function onbehalf(Request $request)
    // {
    //     $leave = Leave::find($id);
    //     $leave->status = 'Declined by HR';
    //     $leave->save();

    //     return redirect()->route('leaves.hrapproval');

    // }

    public function search(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
            // 'leavetype' => 'required',
            'name'=> 'required',
           
        ]);

        $name= $request->name;
        $start_date=$request->start_date;
        $end_date=$request->end_date;
        // $leavetype=$request->leavetype;

        
        $userid = User::where('name',$name)->value('id');
        
  
 
        $leaves = Leave::where([

            ['user_id', $userid],
            ['start_date', '>=', $start_date],
            ['end_date', '<=', $end_date],


        ])->get();

        return view('admin.allstaffleaves.search', ['leaves' => $leaves, 'name'=>$name,'start_date' =>$start_date, 'end_date'=>$end_date]);
    }

}
