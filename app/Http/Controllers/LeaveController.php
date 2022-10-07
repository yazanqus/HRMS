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
use Maatwebsite\Excel\Facades\Excel;

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

        //balance of annual half first and second is from annual leavea
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
        //balance of unpaid half first and second is from unpaid leavea
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

        //balance of comp half day is from comp
        elseif ($request->leavetype_id == '18' || $request->leavetype_id == '19') {

            $balances = Balance::where('user_id', $user->id)->get();
            $subsets = $balances->map(function ($balance) {
                return collect($balance->toArray())

                    ->only(['value', 'leavetype_id'])
                    ->all();
            });
            $final = $subsets->firstwhere('leavetype_id', '18');
            $finalfinal = $final['value'];
            $comphalfleavebalance = $finalfinal;

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

    

        // Annual leave conditions
        if ($request->leavetype_id == '1') {

            if ($probationdays >= '90') {

                if ($days <= $currentbalance) {

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
                            'title' => 'Leave Request Approval - Annual Leave',
                            'body' => 'Access to HR System is now available'
                        ];
                       
                        Mail::to($linemanageremail)->later(5, new MailLeave($details));

                        
                    }

                    $leave->save();
                    // $user->notify(new EmailNotification($leave));
                    

                    return redirect()->route('leaves.index');
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
                            'title' => 'Leave Request Approval - Sick Leave',
                            'body' => 'Access to HR System is now available'
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                }

                $leave->save();
                // $user->notify(new EmailNotification($leave));

                return redirect()->route('leaves.index');
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
                            'title' => 'Leave Request Approval - Sick Leave 30% deduction',
                            'body' => 'Access to HR System is now available'
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                }

                $leave->save();
                // $user->notify(new EmailNotification($leave));

                return redirect()->route('leaves.index');
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
                            'title' => 'Leave Request Approval - Sick Leave 20% deduction',
                            'body' => 'Access to HR System is now available'
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                }

                $leave->save();
                // $user->notify(new EmailNotification($leave));

                return redirect()->route('leaves.index');
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
                            'title' => 'Leave Request Approval - Marriage Leave',
                            'body' => 'Access to HR System is now available'
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                    }

                    $leave->save();

                    return redirect()->route('leaves.index');
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
                            'title' => 'Leave Request Approval - Maternity Leave',
                            'body' => 'Access to HR System is now available'
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                    }

                    $leave->save();

                    return redirect()->route('leaves.index');
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
                            'title' => 'Leave Request Approval - Welfare Leave',
                            'body' => 'Access to HR System is now available'
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                    }

                    $leave->save();

                    return redirect()->route('leaves.index');

                } else {
                    return redirect()->back()->with("error", "Can't submit more than 3 days leave of this type");
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
                            'title' => 'Leave Request Approval - Annual Halfday Leave',
                            'body' => 'Access to HR System is now available'
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                    }

                    $leave->save();

                    return redirect()->route('leaves.index');
                } else {
                    return redirect()->back()->with("error", "Leave remaining balance is not enough");
                }
            } else {
                return redirect()->back()->with("error", "You can't submit leave while still on probation");
            }
        }

        // comp leave hours coditions
        elseif ($request->leavetype_id == '19') {

            if ($comphalfleavebalance >= '0.125') {

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
                            'title' => 'Leave Request Approval - Compensation Leave',
                            'body' => 'Access to HR System is now available'
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

            if ($comphalfleavebalance >= '1') {

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
                            'title' => 'Leave Request Approval - Compensation Leave',
                            'body' => 'Access to HR System is now available'
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                }

                $leave->save();

                return redirect()->route('leaves.index');
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
                            'title' => 'Leave Request Approval - Paternity Leave',
                            'body' => 'Access to HR System is now available'
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                    }

                    $leave->save();

                    return redirect()->route('leaves.index');
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
                            'title' => 'Leave Request Approval - Unpaid Halfday Leave',
                            'body' => 'Access to HR System is now available'
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                    }

                    $leave->save();

                    return redirect()->route('leaves.index');
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
                            'title' => 'Leave Request Approval',
                            'body' => 'Access to HR System is now available'
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                }

                $leave->save();

                return redirect()->route('leaves.index');
            } else {
                return redirect()->back()->with("error", "Can't submit more than 5 days leave of this type");
            }

        }

        //second degree days should be less than 5 days
        elseif ($request->leavetype_id == '7') {

            if ($days <= '3') {

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
                            'title' => 'Leave Request Approval',
                            'body' => 'Access to HR System is now available'
                        ];
                       
                        Mail::to($linemanageremail)->send(new MailLeave($details));
                }

                $leave->save();

                return redirect()->route('leaves.index');
            } else {
                return redirect()->back()->with("error", "Can't submit more than 3 days leave of this type");
            }

        } else {
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
                            'title' => 'Leave Request Approval - Unpaid Leave',
                            'body' => 'Access to HR System is now available'
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Leave $leave)
    {

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
        $leave = Leave::find($id);
        $leave->status = 'Pending HR Approval';

        $requester=$leave->user;

                        $details = [
                            'requestername' => $requester->name,
                            'linemanagername' => '',
                            'linemanageremail' => '',
                            'title' => 'Leave Request Approved',
                            'body' => 'Access to HR System is now available'
                        ];
                       
                        Mail::to($requester->email)->send(new MailLeave($details));

        $leave->save();

        return redirect()->route('leaves.approval');

    }

    public function declined($id)
    {
        $leave = Leave::find($id);
        $leave->status = 'Declined by LM';

        $requester=$leave->user;

        $details = [
            'requestername' => $requester->name,
            'linemanagername' => '',
            'linemanageremail' => '',
            'title' => 'Leave Request Rejected',
            'body' => 'Access to HR System is now available'
        ];
       
        Mail::to($requester->email)->send(new MailLeave($details));
        
        $leave->save();

        return redirect()->route('leaves.approval');

    }

    public function hrapproved($id)
    {
        $leave = Leave::find($id);
        $leave->status = 'Approved';

        $requester=$leave->user;

        $details = [
            'requestername' => $requester->name,
            'linemanagername' => '',
            'linemanageremail' => '',
            'title' => 'Leave Request Fully Approved',
            'body' => 'Access to HR System is now available'
        ];
       
        Mail::to($requester->email)->send(new MailLeave($details));

        $leave->save();

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

    public function hrdeclined($id)
    {
        $leave = Leave::find($id);
        $leave->status = 'Declined by HR';


        $requester=$leave->user;

        $details = [
            'requestername' => $requester->name,
            'linemanagername' => '',
            'linemanageremail' => '',
            'title' => 'Leave Request Rejected by HR',
            'body' => 'Access to HR System is now available'
        ];
       
        Mail::to($requester->email)->send(new MailLeave($details));


        $leave->save();

        return redirect()->route('leaves.hrapproval');

    }

    public function export()
    {
        return Excel::download(new LeavesExport, 'leaves.xlsx');
    }

    // public function onbehalf(Request $request)
    // {
    //     $leave = Leave::find($id);
    //     $leave->status = 'Declined by HR';
    //     $leave->save();

    //     return redirect()->route('leaves.hrapproval');

    // }

}
