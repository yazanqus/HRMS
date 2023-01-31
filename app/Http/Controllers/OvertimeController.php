<?php

namespace App\Http\Controllers;

use App\Exports\OvertimesExport;
use App\Models\Balance;
use App\Models\Overtime;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\Overtime as MailOvertime;
use App\Mail\Overtimeafterlm as MailOvertimeafterlm;
use App\Mail\Overtimefinal as MailOvertimefinal;
use App\Mail\Overtimerejected as MailOvertimerejected;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

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
    {$user = Auth::user();
        $request->validate([

            'type' => 'required',
            'date' => 'required',
            'start_hour' => 'required',
            'end_hour' => 'required|after:start_hour',
            'reason' => 'required',
            'file' => 'nullable|mimes:jpeg,png,jpg,pdf|max:3072',

        ],[
            'type.required'=> trans('overtimeerror.type'), // custom message
            'date.required'=> trans('overtimeerror.date'), // custom message
            'start_hour.required'=> trans('overtimeerror.starthour'), // custom message
            'end_hour.required'=> trans('overtimeerror.endhour'), // custom message
            'end_hour.after'=> trans('overtimeerror.after'), // custom message
            'reason.required'=> trans('overtimeerror.reason'), // custom message
            'file.mimes'=> trans('overtimeerror.mimes'), // custom message
            'file.max'=> trans('overtimeerror.max'), // custom message
            
        ]
    );

        $nrcholidays = [
            '2023-01-01',
            '2023-03-21',
            '2023-04-09',
            '2023-04-16',
            '2023-04-17',
            '2023-04-23',
            '2023-04-24',
            '2023-04-25',
            '2023-05-01',
            '2023-06-28',
            '2023-06-29',
            '2023-06-30',
            '2023-07-01',
            '2023-07-02',
            '2023-07-03',
            '2023-07-19',
            '2023-07-27',
            '2023-08-10',
            '2023-08-10',
            '2023-12-25',
            
        ];

        if ($request->type == 'holiday' && !in_array($request->date , $nrcholidays))
        {
        
            return redirect()->back()->with("error", trans('overtimeerror.holiday'));
        }

        else
        {

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
            if ($request->hasFile('file')) {
                $path = $request->file('file')->store('public/overtimes');
            }
            $overtime = new Overtime();
            $overtime->type = $request->type;
            $overtime->date = $request->date;
            $overtime->start_hour = $request->start_hour;
            $overtime->end_hour = $request->end_hour;
            $overtime->reason = $request->reason;
            $overtime->hours = $last;
            if ($request->hasFile('file')) {
                $overtime->path = $path;
            }
            // $overtime->overtimetype_id = $request->overtimetype_id;
            $overtime->user_id = auth()->user()->id;
            if (!isset($user->linemanager)) {
                $overtime->status = 'Pending HR Approval';
    
            } else {
    
                $overtime->status = 'Pending LM Approval';
                $dayname = Carbon::parse($overtime->date)->format('l');
                $linemanageremail = User::where('name',$user->linemanager)->value('email');
    
                // dd($linemanageremail);
                $details = [
                    'requestername' => $user->name,
                    'linemanagername' => $user->linemanager,
                    'linemanageremail' => $linemanageremail,
                    'title' => 'Overtime Request Approval - '.$overtime->type,
                    'overtimetype' => $overtime->type,
                    'dayname' => $dayname,
                    'date' => $overtime->date,
                    'start_hour' => $overtime->start_hour,
                    'end_hour' => $overtime->end_hour,
                    'hours' => $overtime->hours,
                    'comment' =>  $overtime->reason
                ];
               
                Mail::to($linemanageremail)->send(new MailOvertime($details));
    
    
            }
            if ($overtime->type == 'workday') {
                $overtime->value = $last * 1.5;
            }
            
            else if ($overtime->type == 'SC-overtime')
            {
                $overtime->value = $last * 1;
            }
            //holiday and weekends overtimes:
            else {
                $overtime->value = $last * 2;
            }
    
            $overtime->save();
    
            // dd($partialstoannual);
            return redirect()->route('overtimes.index');
    
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function show($overtimeid)
    {

        $id = decrypt($overtimeid);
        // dd($id);
        $overtime = Overtime::findOrFail($id);
        $overtimes = Overtime::all();
        $users = User::all();

        return view('overtimes.show', ['overtime' => $overtime,'overtimes'=>$overtimes,'users'=>$users]);
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
    public function destroy($id)
    {
        $overtime = Overtime::find($id);
        if (isset($overtime->path)) {
            $file_path = public_path() . '/storage/overtimes/' . basename($overtime->path);
            unlink($file_path);
        }

        $overtime->delete();
        return redirect()->route('overtimes.index');
    }

    public function approved(Request $request,$id)
    {
        $lmuser = Auth::user();
        $overtime = Overtime::find($id);
        $overtime->status = 'Pending HR Approval';
        $overtime->lmapprover = $lmuser->name;
        $overtime->lmcomment = $request->comment;


        $overtime->save();

        $dayname = Carbon::parse($overtime->date)->format('l');
        $requester=$overtime->user;

            // dd($linemanageremail);
            $details = [
                'requestername' => $requester->name,
                'linemanagername' => $requester->linemanager,
                // 'linemanageremail' => $linemanageremail,
                'title' => 'Overtime Request - '.$overtime->type. ' - Approved by Line Manager',
                'overtimetype' => $overtime->type,
                'dayname' => $dayname,
                'date' => $overtime->date,
                'start_hour' => $overtime->start_hour,
                'end_hour' => $overtime->end_hour,
                'hours' => $overtime->hours,
                'status' => $overtime->status,
                'comment' =>  $overtime->reason,
                'lmcomment' => $overtime->lmcomment
            ];
           
            Mail::to($requester->email)->send(new MailOvertimeafterlm($details));

        return redirect()->route('overtimes.approval');

    }

    public function declined(Request $request,$id)
    {
        $lmuser = Auth::user();
        $overtime = Overtime::find($id);
        $overtime->status = 'Declined by LM';
        $overtime->lmapprover = $lmuser->name;
        $overtime->lmcomment = $request->comment;

        $overtime->save();

        $dayname = Carbon::parse($overtime->date)->format('l');
        $requester=$overtime->user;

            // dd($linemanageremail);
            $details = [
                'requestername' => $requester->name,
                'linemanagername' => $requester->linemanager,
                // 'linemanageremail' => $linemanageremail,
                'title' => 'Overtime Request - '.$overtime->type. ' - Declined by Line Manager',
                'overtimetype' => $overtime->type,
                'dayname' => $dayname,
                'date' => $overtime->date,
                'start_hour' => $overtime->start_hour,
                'end_hour' => $overtime->end_hour,
                'hours' => $overtime->hours,
                'status' => $overtime->status,
                'comment' =>  $overtime->reason,
                'lmcomment' => $overtime->lmcomment
            ];
           
            Mail::to($requester->email)->send(new MailOvertimeafterlm($details));

        return redirect()->route('overtimes.approval');

    }


    public function forward(Request $request,$id)
    {
        $overtime = Overtime::find($id);
        $overtime->status = 'Pending extra Approval';
        $overtime->exapprover = $request->extra;
        $overtime->save();
        return redirect()->route('overtimes.hrapproval');
    }

    public function exapproved(Request $request,$id)
    {
        $exuser = Auth::user();
        $overtime = Overtime::find($id);
        $overtime->status = 'Approved by extra Approval';
        $overtime->exapprover = $exuser->name;
        $overtime->excomment = $request->comment;
        $overtime->save();

        return redirect()->route('overtimes.approval');
    }
    public function exdeclined(Request $request,$id)
    {
        $exuser = Auth::user();
        $overtime = Overtime::find($id);
        $overtime->status = 'Declined by extra Approval';
        $overtime->exapprover = $exuser->name;
        $overtime->excomment = $request->comment;
        $overtime->save();

        return redirect()->route('overtimes.approval');
    }


    public function hrapproved(Request $request,$id)
    {
        $hruser = Auth::user();
        $overtime = Overtime::find($id);
        $overtime->status = 'Approved';
        $overtime->hrapprover = $hruser->name;
        $overtime->hrcomment = $request->comment;
        $overtime->save();

        if ($overtime->type == 'week-end') {
            $partialstoannual = $overtime->hours / 8;
           

            $balances = Balance::where('user_id', $overtime->user->id)->get();
            $subsets = $balances->map(function ($balance) {
                return collect($balance->toArray())

                    ->only(['value', 'leavetype_id'])
                    ->all();
            });
            $final = $subsets->firstwhere('leavetype_id', '18');

            $finalfinal = $final['value'];
            $currentbalance = $finalfinal;

            $newbalance = $currentbalance + $partialstoannual;

            Balance::where([
                ['user_id', $overtime->user->id],
                ['leavetype_id', '18'],
            ])->update(['value' => $newbalance]);
        }

        $dayname = Carbon::parse($overtime->date)->format('l');
        $requester=$overtime->user;

            // dd($linemanageremail);
            $details = [
                'requestername' => $requester->name,
                'linemanagername' => $requester->linemanager,
                'hrname' => $overtime->hrapprover,
                // 'linemanageremail' => $linemanageremail,
                'title' => 'Overtime Request - '.$overtime->type. ' - Approved by HR',
                'overtimetype' => $overtime->type,
                'dayname' => $dayname,
                'date' => $overtime->date,
                'start_hour' => $overtime->start_hour,
                'end_hour' => $overtime->end_hour,
                'hours' => $overtime->hours,
                'status' => $overtime->status,
                'comment' =>  $overtime->reason,
                'lmcomment' => $overtime->lmcomment,
                'hrcomment' => $overtime->hrcomment
            ];
           
            Mail::to($requester->email)->send(new MailOvertimefinal($details));
        

        return redirect()->route('overtimes.hrapproval');




    }

    public function hrdeclined(Request $request,$id)
    {
        $hruser = Auth::user();
        $overtime = Overtime::find($id);
        $overtime->status = 'Declined by HR';
        $overtime->hrapprover = $hruser->name;
        $overtime->hrcomment = $request->comment;
        $overtime->save();

        $dayname = Carbon::parse($overtime->date)->format('l');
        $requester=$overtime->user;

            // dd($linemanageremail);
            $details = [
                'requestername' => $requester->name,
                'linemanagername' => $requester->linemanager,
                'hrname' => $overtime->hrapprover,
                // 'linemanageremail' => $linemanageremail,
                'title' => 'Overtime Request - '.$overtime->type. ' - Declined by HR',
                'overtimetype' => $overtime->type,
                'dayname' => $dayname,
                'date' => $overtime->date,
                'start_hour' => $overtime->start_hour,
                'end_hour' => $overtime->end_hour,
                'hours' => $overtime->hours,
                'status' => $overtime->status,
                'comment' =>  $overtime->reason,
                'lmcomment' => $overtime->lmcomment,
                'hrcomment' => $overtime->hrcomment
            ];
           
            Mail::to($requester->email)->send(new MailOvertimerejected($details));

        return redirect()->route('overtimes.hrapproval');

    }

    public function export()
    {
        return Excel::download(new OvertimesExport, 'overtimes.xlsx');
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
        $userpeopleid = User::where('name',$name)->value('employee_number');
         
        $overtimes = Overtime::where([

            ['user_id', $userid],
            ['date', '>=', $start_date],
            ['created_at', '<=', $end_date],


        ])->get();

        $hruser = Auth::user();
        $date = Carbon::now();


        $pdf = Pdf::loadView('admin.allstaffovertimes.report', ['name'=>$name,'userpeopleid'=>$userpeopleid,'hruser'=>$hruser,'date'=>$date, 'start_date'=>$start_date,'end_date'=>$end_date,'overtimes'=>$overtimes])->setOptions(['defaultFont' => 'sans-serif', 'isHtml5ParserEnabled'=> 'true', 'isRemoteEnabled'=> 'true', 'isPhpEnabled'=> 'true'])->setpaper('a4','portrait');

        return $pdf->stream();


    }


    public function search(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
            // 'leavetype' => 'required',
            'name',
           
        ]);

        $hruser = Auth::user();

        $name= $request->name;
        $start_date=$request->start_date;
        $end_date=$request->end_date;
        // $leavetype=$request->leavetype;
        if ($request->name == null)
        {

            if ($hruser->office == "AO2") {
                $overtimes = Overtime::where([
    
                    
                    ['date', '>=', $start_date],
                    ['date', '<=', $end_date],
        
        
                ])->get();
            }
            else {
                $staffwithsameoffice = User::where('office',$hruser->office)->get();
            if (count($staffwithsameoffice))
            {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                    return collect($staffwithsameoffice->toArray())
                        ->only(['id'])
                        ->all();
                });
                $overtimes = Overtime::wherein('user_id', $hrsubsets)->where([
                    ['date', '>=', $start_date],
                    ['date', '<=', $end_date],
                ])->get();
                
            }       
            }
        }
        
        else
        {
            $userid = User::where('name',$name)->value('id');
        
  
 
            $overtimes = Overtime::where([
    
                ['user_id', $userid],
                ['date', '>=', $start_date],
                ['date', '<=', $end_date],
    
    
            ])->get();
        }
       

        return view('admin.allstaffovertimes.search', ['overtimes' => $overtimes, 'name'=>$name,'start_date' =>$start_date, 'end_date'=>$end_date]);
    }
}
