<?php
namespace App\Http\Middleware;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\ComlistController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\UserController;
use App\Mail\Leave as MailLeave;
use App\Models\Attendance;
use App\Models\Balance;
use App\Models\Leave;
use App\Models\Leavetype;
use App\Models\Overtime;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::get('/', function () {
    
    return redirect('welcome');
})->name('home');



Route::get('/change-language/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'ar'])) {        
        abort(404);
    }
    DB::table('users')->where('id' , Auth::user()->id)->update(
        ['preflang' => $locale]); 
    return redirect()->back();
  })->middleware(\App\Http\Middleware\Localization::class)->name('locale');

  Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth', 'checkstatus', 'hradmin'], 'prefix' => '/admin', 'as' => 'admin.'], function () {
    Route::get('/leaves/export', [LeaveController::class, 'export'])->name('leaves.export');
    Route::get('leavespdf', function ()
    {


        $hruser = Auth::user();

        if ($hruser->office == "AO2") {
            $users = User::all();
            $leaves = Leave::all();
            return view('admin.allstaffleaves.reportconditions', ['leaves' => $leaves,'users' => $users]);
        }
        else
        {  
            $staffwithsameoffice = User::where('office',$hruser->office)->get();
            if (count($staffwithsameoffice))
            {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                    return collect($staffwithsameoffice->toArray())
                        ->only(['id'])
                        ->all();
                });
                $hrleaves = Leave::wherein('user_id', $hrsubsets)->get();

                return view('admin.allstaffleaves.reportconditions', ['leaves' => $hrleaves,'users' => $staffwithsameoffice]);
            }            

        }


        // $users = User::all();
        // $leaves = Leave::all();
        // $leavestypes = Leavetype::all();
        // return view('admin.allstaffleaves.reportconditions', ['leaves' => $leaves, 'users' => $users, 'leavestypes' => $leavestypes]);

    })->name('leaves.pdf');
    Route::post('/leaves/pdf/show', [LeaveController::class, 'pdf'])->name('leaves.pdfshow');

    
    Route::get('/overtimes/export', [OvertimeController::class, 'export'])->name('overtimes.export');
    Route::get('overtimespdf', function ()
    {
        $users = User::all();
        $overtimes = Overtime::all();
       
        return view('admin.allstaffovertimes.reportconditions', ['overtimes' => $overtimes, 'users' => $users]);

    })->name('overtimes.pdf');

    Route::post('/overtimes/pdf/show', [OvertimeController::class, 'pdf'])->name('overtimes.pdfshow');
    Route::get('allstaffleaves', function () {
        $hruser = Auth::user();
        if ($hruser->office == "AO2") {
            $leaves = Leave::all();
            return view('admin.allstaffleaves.index', ['leaves' => $leaves]);
        }
        else
        {  
            $staffwithsameoffice = User::where('office',$hruser->office)->get();
            if (count($staffwithsameoffice))
            {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                    return collect($staffwithsameoffice->toArray())
                        ->only(['id'])
                        ->all();
                });
                $hrleaves = Leave::wherein('user_id', $hrsubsets)->get();
                return view('admin.allstaffleaves.index', ['leaves' => $hrleaves]);
            }            

        }
    })->name('allstaffleaves.index');

    Route::get('allleavessearch', function () {
        $hruser = Auth::user();

        if ($hruser->office == "AO2") {
            $users = User::all()->except(1);
            $leaves = Leave::all();
            return view('admin.allstaffleaves.searchconditions', ['leaves' => $leaves,'users' => $users]);
        }
        else
        {  
            $staffwithsameoffice = User::where('office',$hruser->office)->get();
            if (count($staffwithsameoffice))
            {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                    return collect($staffwithsameoffice->toArray())
                        ->only(['id'])
                        ->all();
                });
                $hrleaves = Leave::wherein('user_id', $hrsubsets)->get();

                return view('admin.allstaffleaves.searchconditions', ['leaves' => $hrleaves,'users' => $staffwithsameoffice]);
            }            

        }
    })->name('allleavessearch.cond');

    Route::post('/leaves/search', [LeaveController::class, 'search'])->name('leaves.search');

    Route::get('alluserssearch', function () {
        $hruser = Auth::user();

        if ($hruser->office == "AO2") {
            $users = User::all()->except(1);
            
            return view('admin.users.searchconditions', ['users' => $users]);
        }
        else
        {  
            $staffwithsameoffice = User::where('office',$hruser->office)->get();
            if (count($staffwithsameoffice))
            {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                    return collect($staffwithsameoffice->toArray())
                        ->only(['id'])
                        ->all();
                });
                $hrusers = User::wherein('id', $hrsubsets)->get();

                return view('admin.users.searchconditions', ['users' => $hrusers]);
            }            

        }
    })->name('alluserssearch.cond');

    Route::post('/users/search', [UserController::class, 'search'])->name('users.search');


    Route::get('allusersbalanceexport', function () {
        $hruser = Auth::user();

        if ($hruser->office == "AO2") {
            $users = User::all()->except(1);
            
            return view('admin.users.balanceconditions', ['users' => $users]);
        }
        else
        {  
            $staffwithsameoffice = User::where('office',$hruser->office)->get();
            if (count($staffwithsameoffice))
            {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                    return collect($staffwithsameoffice->toArray())
                        ->only(['id'])
                        ->all();
                });
                $hrusers = User::wherein('id', $hrsubsets)->get();

                return view('admin.users.balanceconditions', ['users' => $hrusers]);
            }            

        }
    })->name('allusersbalanceexport.cond');


    Route::get('allovertimessearch', function () {
        $hruser = Auth::user();

        if ($hruser->office == "AO2") {
            $users = User::all()->except(1);
            $overtimes = Overtime::all();
            return view('admin.allstaffovertimes.searchconditions', ['overtimes' => $overtimes,'users' => $users]);
        }
        else
        {  
            $staffwithsameoffice = User::where('office',$hruser->office)->get();
            if (count($staffwithsameoffice))
            {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                    return collect($staffwithsameoffice->toArray())
                        ->only(['id'])
                        ->all();
                });
                $hrovertimes = Overtime::wherein('user_id', $hrsubsets)->get();

                return view('admin.allstaffovertimes.searchconditions', ['overtimes' => $hrovertimes,'users' => $staffwithsameoffice]);
            }            

        }
    })->name('allovertimessearch.cond');

    Route::post('/overtimes/search', [OvertimeController::class, 'search'])->name('overtimes.search');

    Route::get('allstaffovertimes', function () {
 
        $hruser = Auth::user();
        if ($hruser->office == "AO2") {
            $overtimes = Overtime::all();
            return view('admin.allstaffovertimes.index', ['overtimes' => $overtimes]);
        }
        else
        {  
            $staffwithsameoffice = User::where('office',$hruser->office)->get();
            if (count($staffwithsameoffice))
            {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                    return collect($staffwithsameoffice->toArray())
                        ->only(['id'])
                        ->all();
                });
                $hrovertimes = Overtime::wherein('user_id', $hrsubsets)->get();
                return view('admin.allstaffovertimes.index', ['overtimes' => $hrovertimes]);
            }            

        }
    })->name('allstaffovertimes.index');

    Route::get('allstaffbalances', function () {
        $users = User::all();
        $balances = Balance::all();
        return view('admin.allstaffbalances.index', ['users' => $users]);
    })->name('allstaffbalances.index');

    Route::get('activityleaves', function () {
        $allactivity = Activity::all();
        return view('admin.activitylogleaves.index', ['allactivity' => $allactivity]);
    })->name('activityleaves.index');

    Route::get('activityovertimes', function () {
        $allactivity = Activity::all();
        return view('admin.activitylogovertime.index', ['allactivity' => $allactivity]);
    })->name('activityovertimes.index');

    Route::get('activityusers', function () {
        $allactivity = Activity::all();
        return view('admin.activitylogusers.index', ['allactivity' => $allactivity]);
    })->name('activityusers.index');

    Route::get('allstaffattendances', function () {
        $attendances = Attendance::whereNull('user_id')->get();
        return view('admin.allstaffattendances.index', ['attendances' => $attendances]);
    })->name('allstaffattendances.index');

});

Route::group(['middleware' => ['auth', 'checkstatus', 'hradmin']], function () {
    Route::get('leaves/hrapproval', function () {    

        $hrcurrentuser = Auth::user();
        $users = User::all();
        if($hrcurrentuser->office == "AO2")
        {
            $leaves = Leave::where('status', 'Pending HR Approval')->orWhere('status', 'Approved by extra Approval')->orWhere('status', 'Declined by extra Approval')->get();
            
            if (count($leaves)) {
                return view('hrapproval.leaves.index', ['users'=>$users,'leaves' => $leaves]);
            } else {
                $leavess = Leave::where([
                    ['status', 'no staff under this line manager'],
                ])->get();    
                return view('hrapproval.leaves.index', ['users'=>$users,'leaves' => $leavess]);
            }
        }
        else
        {
            $staffwithsameoffice = User::where('office',$hrcurrentuser->office)->get();
            if (count($staffwithsameoffice)) {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                            return collect($staffwithsameoffice->toArray())
                                ->only(['id'])
                                ->all();
                        });
                        $leaves = Leave::whereIn('user_id', $hrsubsets)->where(function($query) {
                            $query->where('status', 'Pending HR Approval')
                        ->orwhere('status', 'Approved by extra Approval')->orwhere('status', 'Declined by extra Approval');})->get();
                            if (count($leaves)) {
                                return view('hrapproval.leaves.index', ['users'=>$users,'leaves' => $leaves]);
                            } else {
                                $leavess = Leave::where([
                                    ['user_id', 'fake'],
                                    ['status', 'no staff under this line manager'],
                                ])->get();
                                
                                return view('hrapproval.leaves.index', ['users'=>$users,'leaves' => $leavess]);
                            }
            }
            else
            {
                $leavess = Leave::where([
                            ['user_id', 'fake'],
                            ['status', 'no staff under this line manager'],
                        ])->get();
                        // dd($leavess);
                
                        return view('hrapproval.leaves.index', ['users'=>$users,'leaves' => $leavess]);
                    }
            }
        }

    )->name('leaves.hrapproval');   

    Route::get('overtimes/hrapproval', function () {


        $hrcurrentuser = Auth::user();
        $users = User::all();
        
        if($hrcurrentuser->office == "AO2")
        {
            $overtimes = Overtime::where('status', 'Pending HR Approval')->orWhere('status', 'Approved by extra Approval')->orWhere('status', 'Declined by extra Approval')->get();
            
            if (count($overtimes)) {
                return view('hrapproval.overtimes.index', ['users'=>$users,'overtimes' => $overtimes]);
            } else {
                $overtimess = Overtime::where([
                    ['status', 'no staff under this line manager'],
                ])->get();    
                return view('hrapproval.overtimes.index', ['users'=>$users,'overtimes' => $overtimess]);
            }
        }
        else
        {
            $staffwithsameoffice = User::where('office',$hrcurrentuser->office)->get();
            if (count($staffwithsameoffice)) {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                            return collect($staffwithsameoffice->toArray())
                                ->only(['id'])
                                ->all();
                        });
                        $overtimes = Overtime::whereIn('user_id', $hrsubsets)->where(function($query) {
                            $query->where('status', 'Pending HR Approval')
                        ->orwhere('status', 'Approved by extra Approval')->orwhere('status', 'Declined by extra Approval');})->get();
                            if (count($overtimes)) {
                                return view('hrapproval.overtimes.index', ['users'=>$users,'overtimes' => $overtimes]);
                            } else {
                                $overtimess = Overtime::where([
                                    ['user_id', 'fake'],
                                    ['status', 'no staff under this line manager'],
                                ])->get();
                                
                                return view('hrapproval.overtimes.index', ['users'=>$users,'overtimes' => $overtimess]);
                            }
            }

            else
            {
                $overtimess = Overtime::where([
                            ['user_id', 'fake'],
                            ['status', 'no staff under this line manager'],
                        ])->get();
                        // dd($overtimess);
                
                        return view('hrapproval.overtimes.index', ['users'=>$users,'overtimes' => $overtimess]);
                    }
            }
        }

    )->name('overtimes.hrapproval');

    Route::get('attendances/approval/hr/staff/{attendance}', function ($attendance) {

        // if ($attendance == '5') {
        //     $monthh = 'May';
        // }

        if ($attendance == '1') {
            $month = 'January';
            $users = User::whereHas('attendances', function ($q) {
                $q->where(['status' => 'Pending HR Approval',
                    ['month', 'January'],
                ]);
            })->get();
        } elseif ($attendance == '2') {
            $month = 'February';
            $users = User::whereHas('attendances', function ($q) {
                $q->where(['status' => 'Pending HR Approval',
                    ['month', 'February'],
                ]);
            })->get();
        } elseif ($attendance == '3') {
            $month = 'March';
            $users = User::whereHas('attendances', function ($q) {
                $q->where(['status' => 'Pending HR Approval',
                    ['month', 'March'],
                ]);
            })->get();
        } elseif ($attendance == '4') {
            $month = 'April';
            $users = User::whereHas('attendances', function ($q) {
                $q->where(['status' => 'Pending HR Approval',
                    ['month', 'April'],
                ]);
            })->get();
        } elseif ($attendance == '5') {
            $month = 'May';
            $users = User::whereHas('attendances', function ($q) {
                $q->where(['status' => 'Pending HR Approval',
                    ['month', 'May'],
                ]);
            })->get();
        } elseif ($attendance == '6') {
            $month = 'June';
            $users = User::whereHas('attendances', function ($q) {
                $q->where(['status' => 'Pending HR Approval',
                    ['month', 'June'],
                ]);
            })->get();
        } elseif ($attendance == '7') {
            $month = 'July';
            $users = User::whereHas('attendances', function ($q) {
                $q->where(['status' => 'Pending HR Approval',
                    ['month', 'July'],
                ]);
            })->get();
        } elseif ($attendance == '8') {
            $month = 'August';
            $users = User::whereHas('attendances', function ($q) {
                $q->where(['status' => 'Pending HR Approval',
                    ['month', 'August'],
                ]);
            })->get();
        } elseif ($attendance == '9') {
            $month = 'September';
            $users = User::whereHas('attendances', function ($q) {
                $q->where(['status' => 'Pending HR Approval',
                    ['month', 'September'],
                ]);
            })->get();
        } elseif ($attendance == '10') {
            $month = 'October';
            $users = User::whereHas('attendances', function ($q) {
                $q->where(['status' => 'Pending HR Approval',
                    ['month', 'October'],
                ]);
            })->get();
        } elseif ($attendance == '11') {
            $month = 'November';
            $users = User::whereHas('attendances', function ($q) {
                $q->where(['status' => 'Pending HR Approval',
                    ['month', 'November'],
                ]);
            })->get();
        } elseif ($attendance == '12') {
            $month = 'December';
            $users = User::whereHas('attendances', function ($q) {
                $q->where(['status' => 'Pending HR Approval',
                    ['month', 'December'],
                ]);
            })->get();
        }

        return view('hrapproval.attendances.staff', ['users' => $users, 'attendance' => $attendance, 'month' => $month]);

    })->name('attendances.approval.hr.staff');

    Route::get('attendances/approval/hr/staff/{attendance}/{user}', function ($attendance, $user) {

        if ($attendance == '1') {
            $search = '-01-';
            $attendances = Attendance::where([
                ['user_id', $user],
                ['day', 'LIKE', '%' . $search . '%'],
                ['status', 'Pending HR Approval']])->get();
        } elseif ($attendance == '2') {
            $search = '-02-';
            $attendances = Attendance::where([
                ['user_id', $user],
                ['day', 'LIKE', '%' . $search . '%'],
                ['status', 'Pending HR Approval']])->get();
        } elseif ($attendance == '3') {
            $search = '-03-';
            $attendances = Attendance::where([
                ['user_id', $user],
                ['day', 'LIKE', '%' . $search . '%'],
                ['status', 'Pending HR Approval']])->get();
        } elseif ($attendance == '4') {
            $search = '-04-';
            $attendances = Attendance::where([
                ['user_id', $user],
                ['day', 'LIKE', '%' . $search . '%'],
                ['status', 'Pending HR Approval']])->get();
        } elseif ($attendance == '6') {
            $search = '-06-';
            $attendances = Attendance::where([
                ['user_id', $user],
                ['day', 'LIKE', '%' . $search . '%'],
                ['status', 'Pending HR Approval']])->get();
        } elseif ($attendance == '7') {
            $search = '-07-';
            $attendances = Attendance::where([
                ['user_id', $user],
                ['day', 'LIKE', '%' . $search . '%'],
                ['status', 'Pending HR Approval']])->get();
        } elseif ($attendance == '8') {
            $search = '-08-';
            $attendances = Attendance::where([
                ['user_id', $user],
                ['day', 'LIKE', '%' . $search . '%'],
                ['status', 'Pending HR Approval']])->get();
        } elseif ($attendance == '9') {
            $search = '-09-';
            $attendances = Attendance::where([
                ['user_id', $user],
                ['day', 'LIKE', '%' . $search . '%'],
                ['status', 'Pending HR Approval']])->get();
        } elseif ($attendance == '10') {
            $search = '-10-';
            $attendances = Attendance::where([
                ['user_id', $user],
                ['day', 'LIKE', '%' . $search . '%'],
                ['status', 'Pending HR Approval']])->get();
        } elseif ($attendance == '11') {
            $search = '-11-';
            $attendances = Attendance::where([
                ['user_id', $user],
                ['day', 'LIKE', '%' . $search . '%'],
                ['status', 'Pending HR Approval']])->get();
        } elseif ($attendance == '12') {
            $search = '-12-';
            $attendances = Attendance::where([
                ['user_id', $user],
                ['day', 'LIKE', '%' . $search . '%'],
                ['status', 'Pending HR Approval']])->get();
        }

        $userrr = User::where('id', $user)->get();
        // dd($userr);

        return view('hrapproval.attendances.show', [
            'user' => $userrr,
            'attendances' => $attendances,
        ]);

    })->name('attendances.approval.hr.staff.show');

});

Route::get('/login/okta', 'App\Http\Controllers\Auth\LoginController@redirectToProvider')->name('login-okta');

Route::get('/login/okta/callback', 'App\Http\Controllers\Auth\LoginController@handleProviderCallback');

Route::get('/logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['auth', 'checkstatus']], function () {

    Route::get('welcome', function () {
       
        $user = Auth::user();
        $balances = Balance::where('user_id', $user->id)->get();
        $subsets = $balances->map(function ($balance) {
            return collect($balance->toArray())

                ->only(['value', 'leavetype_id'])
                ->all();
        });
        $leave1 = $subsets->firstwhere('leavetype_id', '1');
        $balance1 = round($leave1['value'],3);

        $leave2 = $subsets->firstwhere('leavetype_id', '2');
        $balance2 = round($leave2['value'],3);

        $leave12 = $subsets->firstwhere('leavetype_id', '12');
        $balance12 = $leave12['value'];

        $leave18 = $subsets->firstwhere('leavetype_id', '18');
        $balance18 = round($leave18['value'],3);

        return view('dashboard', ['user' => $user, 'balance1' => $balance1, 'balance2' => $balance2, 'balance12' => $balance12, 'balance18' => $balance18]);
    })->name('welcome');


    
    Route::get('leaves/approval', function () {
        $user = Auth::user();
        $staff = User::where('linemanager', $user->name)->get();
        // dd($staff);
        if (count($staff)) {

            $subsets = $staff->map(function ($staff) {
                return collect($staff->toArray())

                    ->only(['id'])
                    ->all();
            });

            $leaves = Leave::whereIn('user_id', $subsets)
            ->where('status', 'Pending LM Approval')
            ->orwhere(function($query) use($user) {
                $query->where('status', 'Pending extra Approval')
            ->where('exapprover', $user->name);})
            ->get();

            if (count($leaves)) {
                return view('approval.leaves.index', ['leaves' => $leaves]);

            } else {

                $leavess = Leave::where([
                    ['user_id', $user->id],
                    ['status', 'no staff under this line manager'],
                ])->orwhere(function($query) use($user) {
                    $query->where('status', 'Pending extra Approval')
                ->where('exapprover', $user->name);})
                ->get();
                // dd($leavess);

                return view('approval.leaves.index', ['leaves' => $leavess]);
            }

        } else {
            $leavess = Leave::where([
                ['user_id', $user->id],
                ['status', 'no staff under this line manager'],
            ])->orwhere(function($query) use($user) {
                $query->where('status', 'Pending extra Approval')
            ->where('exapprover', $user->name);})
            ->get();
            // dd($leavess);

            return view('approval.leaves.index', ['leaves' => $leavess]);
        }

    })->name('leaves.approval');

    // probalby not used
    // Route::get('attendances/approval/lm', function () {

    //     $user = Auth::user();
    //     $staff = User::where('linemanager', $user->name)->get();
    //     // dd($staff);
    //     if (count($staff)) {

    //         $subsets = $staff->map(function ($staff) {
    //             return collect($staff->toArray())

    //                 ->only(['id'])
    //                 ->all();
    //         });

    //         $attendances = Attendance::whereIn('user_id', $subsets)->where('status', 'Pending LM Approval')->get();

    //         if (count($attendances)) {
    //             return view('approval.attendances.show', ['attendances' => $attendances]);

    //         } else {

    //             $attendancess = Attendance::where([
    //                 ['user_id', $user->id],
    //                 ['status', 'no staff under this line manager'],
    //             ])->get();

    //             return view('approval.attendances.show', ['attendances' => $attendancess]);
    //         }

    //     } else {
    //         $attendancess = Attendance::where([
    //             ['user_id', $user->id],
    //             ['status', 'no staff under this line manager'],
    //         ])->get();

    //         return view('approval.attendances.show', ['attendances' => $attendancess]);
    //     }

    // })->name('attendances.approval.lm');

    // Route::get('attendances/approval/lm/staff/{attendance}', function ($attendance) {

    //     $user = Auth::user();
    //     if ($attendance == '1') {
    //         $month = 'January';
    //         $users = User::whereHas('attendances', function ($q) {
    //             $q->where(['status' => 'Pending LM Approval',
    //                 ['month', 'January'],
    //             ]);
    //         })->where('linemanager', $user->name)->get();
    //     } elseif ($attendance == '2') {
    //         $month = 'February';
    //         $users = User::whereHas('attendances', function ($q) {
    //             $q->where(['status' => 'Pending LM Approval',
    //                 ['month', 'February'],
    //             ]);
    //         })->where('linemanager', $user->name)->get();
    //     } elseif ($attendance == '3') {
    //         $month = 'March';
    //         $users = User::whereHas('attendances', function ($q) {
    //             $q->where(['status' => 'Pending LM Approval',
    //                 ['month', 'March'],
    //             ]);
    //         })->where('linemanager', $user->name)->get();
    //     } elseif ($attendance == '4') {
    //         $month = 'April';
    //         $users = User::whereHas('attendances', function ($q) {
    //             $q->where(['status' => 'Pending LM Approval',
    //                 ['month', 'April'],
    //             ]);
    //         })->where('linemanager', $user->name)->get();
    //     } elseif ($attendance == '5') {
    //         $month = 'May';
    //         $users = User::whereHas('attendances', function ($q) {
    //             $q->where(['status' => 'Pending LM Approval',
    //                 ['month', 'May'],
    //             ]);
    //         })->where('linemanager', $user->name)->get();
    //     } elseif ($attendance == '6') {
    //         $month = 'June';
    //         $users = User::whereHas('attendances', function ($q) {
    //             $q->where(['status' => 'Pending LM Approval',
    //                 ['month', 'June'],
    //             ]);
    //         })->where('linemanager', $user->name)->get();
    //     } elseif ($attendance == '7') {
    //         $month = 'July';
    //         $users = User::whereHas('attendances', function ($q) {
    //             $q->where(['status' => 'Pending LM Approval',
    //                 ['month', 'July'],
    //             ]);
    //         })->where('linemanager', $user->name)->get();
    //     } elseif ($attendance == '8') {
    //         $month = 'August';
    //         $users = User::whereHas('attendances', function ($q) {
    //             $q->where(['status' => 'Pending LM Approval',
    //                 ['month', 'August'],
    //             ]);
    //         })->where('linemanager', $user->name)->get();
    //     } elseif ($attendance == '9') {
    //         $month = 'September';
    //         $users = User::whereHas('attendances', function ($q) {
    //             $q->where(['status' => 'Pending LM Approval',
    //                 ['month', 'September'],
    //             ]);
    //         })->where('linemanager', $user->name)->get();
    //     } elseif ($attendance == '10') {
    //         $month = 'October';
    //         $users = User::whereHas('attendances', function ($q) {
    //             $q->where(['status' => 'Pending LM Approval',
    //                 ['month', 'October'],
    //             ]);
    //         })->where('linemanager', $user->name)->get();
    //     } elseif ($attendance == '11') {
    //         $month = 'November';
    //         $users = User::whereHas('attendances', function ($q) {
    //             $q->where(['status' => 'Pending LM Approval',
    //                 ['month', 'November'],
    //             ]);
    //         })->where('linemanager', $user->name)->get();
    //     } elseif ($attendance == '12') {
    //         $month = 'December';
    //         $users = User::whereHas('attendances', function ($q) {
    //             $q->where(['status' => 'Pending LM Approval',
    //                 ['month', 'December'],
    //             ]);
    //         })->where('linemanager', $user->name)->get();
    //     }

    //     // dd($users)

    //     return view('approval.attendances.staff', ['users' => $users, 'attendance' => $attendance, 'month' => $month]);

    // })->name('attendances.approval.lm.staff');

    // Route::get('attendances/approval/lm/staff/{attendance}/{user}', function ($attendance, $user) {

    //     if ($attendance == '1') {
    //         $search = '-01-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user],
    //             ['day', 'LIKE', '%' . $search . '%'],
    //             ['status', 'Pending LM Approval']])->get();
    //     } elseif ($attendance == '2') {
    //         $search = '-02-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user],
    //             ['day', 'LIKE', '%' . $search . '%'],
    //             ['status', 'Pending LM Approval']])->get();
    //     } elseif ($attendance == '3') {
    //         $search = '-03-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user],
    //             ['day', 'LIKE', '%' . $search . '%'],
    //             ['status', 'Pending LM Approval']])->get();
    //     } elseif ($attendance == '4') {
    //         $search = '-04-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user],
    //             ['day', 'LIKE', '%' . $search . '%'],
    //             ['status', 'Pending LM Approval']])->get();
    //     } elseif ($attendance == '6') {
    //         $search = '-06-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user],
    //             ['day', 'LIKE', '%' . $search . '%'],
    //             ['status', 'Pending LM Approval']])->get();
    //     } elseif ($attendance == '7') {
    //         $search = '-07-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user],
    //             ['day', 'LIKE', '%' . $search . '%'],
    //             ['status', 'Pending LM Approval']])->get();
    //     } elseif ($attendance == '8') {
    //         $search = '-08-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user],
    //             ['day', 'LIKE', '%' . $search . '%'],
    //             ['status', 'Pending LM Approval']])->get();
    //     } elseif ($attendance == '9') {
    //         $search = '-09-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user],
    //             ['day', 'LIKE', '%' . $search . '%'],
    //             ['status', 'Pending LM Approval']])->get();
    //     } elseif ($attendance == '10') {
    //         $search = '-10-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user],
    //             ['day', 'LIKE', '%' . $search . '%'],
    //             ['status', 'Pending LM Approval']])->get();
    //     } elseif ($attendance == '11') {
    //         $search = '-11-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user],
    //             ['day', 'LIKE', '%' . $search . '%'],
    //             ['status', 'Pending LM Approval']])->get();
    //     } elseif ($attendance == '12') {
    //         $search = '-12-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user],
    //             ['day', 'LIKE', '%' . $search . '%'],
    //             ['status', 'Pending LM Approval']])->get();
    //     }
    //     //end januaury if

    //     $userrr = User::where('id', $user)->get();
    //     // dd($userr);

    //     return view('approval.attendances.show', [
    //         'user' => $userrr,
    //         'attendances' => $attendances,
    //     ]);

    // })->name('attendances.approval.lm.staff.show');

    Route::get('overtimes/approval', function () {
        $user = Auth::user();
        $staff = User::where('linemanager', $user->name)->get();
        // dd($staff);
        if (count($staff)) {

            $subsets = $staff->map(function ($staff) {
                return collect($staff->toArray())

                    ->only(['id'])
                    ->all();
            });
            // dd($subsets);
            // $leaves = Leave::whereIn([
            //     ['user_id', $subsets],
            //     ['status', 'Pending Approval'],
            // ])->get();

            $overtimes = Overtime::whereIn('user_id', $subsets)
            ->where('status', 'Pending LM Approval')
            ->orwhere(function($query) use($user) {
                $query->where('status', 'Pending extra Approval')
            ->where('exapprover', $user->name);})
            ->get();
            // $leaves = Leave::where('Status', 'Pending Approval')->get();
            // dd($leaves);
            if (count($overtimes)) {
                return view('approval.overtimes.index', ['overtimes' => $overtimes]);

            } else {

                $overtimess = Overtime::where([
                    ['user_id', $user->id],
                    ['status', 'no staff under this line manager'],
                ])->orwhere(function($query) use($user) {
                    $query->where('status', 'Pending extra Approval')
                ->where('exapprover', $user->name);})
                ->get();
                // dd($leavess);

                return view('approval.overtimes.index', ['overtimes' => $overtimess]);
            }

        } else {
            $overtimess = Overtime::where([
                ['user_id', $user->id],
                ['status', 'no staff under this line manager'],
            ])->orwhere(function($query) use($user) {
                $query->where('status', 'Pending extra Approval')
            ->where('exapprover', $user->name);})
            ->get();

            return view('approval.overtimes.index', ['overtimes' => $overtimess]);
        }

    })->name('overtimes.approval');

    Route::get('/users/{user}/myallstaffattendance', [UserController::class, 'myallstaffattendance'])->name('my.allstaffattendance');
    Route::get('/users/{user}/mystaffattendance/{attendance}', [UserController::class, 'mystaffattendance'])->name('my.staffattendance');

    Route::get('staffleaves', function () {

        $user = Auth::user();
        $staff = User::where('linemanager', $user->name)->get();
        // dd($user);
        if (count($staff)) {
            $subsets = $staff->map(function ($staff) {
                return collect($staff->toArray())

                    ->only(['id'])
                    ->all();
            });

            $leaves = Leave::whereIn('user_id', $subsets)->get();
            $overtimes = Overtime::whereIn('user_id', $subsets)->get();
            return view('staffleaves.index', ['leaves' => $leaves, 'users' => $staff, 'overtimes' => $overtimes]);
        } else {
            $leavess = Leave::where([
                ['user_id', $user->id],
                ['status', 'no staff under this line manager'],
            ])->get();
            // dd($leavess);
            $overtimess = Overtime::where([
                ['user_id', $user->id],
                ['status', 'no staff under this line manager'],
            ])->get();

            return view('staffleaves.index', ['leaves' => $leavess, 'users' => $staff, 'overtimes' => $overtimess]);
        }

    })->name('staffleaves');

    

    Route::get('/changePassword', [ChangePassword::class, 'showChangePasswordGet'])->name('changePasswordGet');
    Route::post('/changePassword', [ChangePassword::class, 'changePasswordPost'])->name('changePasswordPost');
});

// Route::group(['middleware' => 'auth'], function () {
//     Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
//     Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
//     Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
//     Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
// });

Route::group(['middleware' => ['auth', 'checkstatus', 'hradmin'], 'prefix' => '/admin', 'as' => 'admin.'], function () {
    Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
    Route::post('/users/balanceexport', [UserController::class, 'balanceexport'])->name('users.balanceexport');
    Route::post('/users/import', [UserController::class, 'import'])->name('users.import');
    Route::get('/users/import/show', [UserController::class, 'importshow'])->name('users.importshow');
    Route::get('/users/createbalance', [UserController::class, 'createbalance'])->name('users.createbalance');
    Route::get('/users/{user}/allstaffattendance', [UserController::class, 'allstaffattendance'])->name('users.allstaffattendance');
    Route::get('/users/{user}/staffattendance/{attendance}', [UserController::class, 'staffattendance'])->name('users.staffattendance');
    Route::resource('users', UserController::class);
    Route::get('/users/suspend/{id}', [UserController::class, 'suspend'])->name('users.suspend');
    Route::get('/users/removesuspend/{id}', [UserController::class, 'removesuspend'])->name('users.removesuspend');
    Route::get('/users/{user}/balanceedit', [UserController::class, 'balanceedit'])->name('users.balanceedit');
    Route::put('/users/{user}/balanceupdate', [UserController::class, 'balanceupdate'])->name('users.balanceupdate');

});

Route::group(['middleware' => ['auth', 'checkstatus'], 'prefix' => '/admin', 'as' => 'admin.'], function () {
    Route::resource('policies', PolicyController::class);
});

Route::group(['middleware' => ['auth', 'checkstatus'], 'prefix' => '/admin', 'as' => 'admin.'], function () {
    Route::resource('holidays', HolidayController::class);
});

Route::group(['middleware' => ['auth', 'checkstatus']], function () {
    Route::resource('leaves', LeaveController::class)->except(['show']);
    Route::get('/leaves/{leave}', [LeaveController::class, 'show'])->name('leaves.show');
    Route::get('/leaves/onbehalf', [LeaveController::class, 'onbehalf'])->name('leaves.onbehalf');
    Route::post('/leaves/approved/{id}', [LeaveController::class, 'approved'])->name('leaves.approved');
    Route::post('/leaves/declined/{id}', [LeaveController::class, 'declined'])->name('leaves.declined');
    Route::post('/leaves/hrapproved/{id}', [LeaveController::class, 'hrapproved'])->name('leaves.hrapproved');
    Route::post('/leaves/hrdeclined/{id}', [LeaveController::class, 'hrdeclined'])->name('leaves.hrdeclined');
    Route::post('/leaves/forward/{id}', [LeaveController::class, 'forward'])->name('leaves.forward');
    Route::post('/leaves/exapproved/{id}', [LeaveController::class, 'exapproved'])->name('leaves.exapproved');
    Route::post('/leaves/exdeclined/{id}', [LeaveController::class, 'exdeclined'])->name('leaves.exdeclined');
    Route::post('/leaves/hrdelete/{id}', [LeaveController::class, 'hrdelete'])->name('leaves.hrdelete');
    Route::post('/leaves/lmrevert/{id}', [LeaveController::class, 'lmrevert'])->name('leaves.lmrevert');

    Route::resource('comlists', ComlistController::class)->except(['show']);
});

Route::group(['middleware' => ['auth', 'checkstatus']], function () {
    Route::resource('overtimes', OvertimeController::class);
    Route::post('/overtimes/approved/{id}', [OvertimeController::class, 'approved'])->name('overtimes.approved');
    Route::post('/overtimes/declined/{id}', [OvertimeController::class, 'declined'])->name('overtimes.declined');
    Route::post('/overtimes/hrapproved/{id}', [OvertimeController::class, 'hrapproved'])->name('overtimes.hrapproved');
    Route::post('/overtimes/hrdeclined/{id}', [OvertimeController::class, 'hrdeclined'])->name('overtimes.hrdeclined');
    Route::post('/overtimes/forward/{id}', [OvertimeController::class, 'forward'])->name('overtimes.forward');
    Route::post('/overtimes/exapproved/{id}', [OvertimeController::class, 'exapproved'])->name('overtimes.exapproved');
    Route::post('/overtimes/exdeclined/{id}', [OvertimeController::class, 'exdeclined'])->name('overtimes.exdeclined');
});

Route::group(['middleware' => ['auth', 'checkstatus']], function () {
    Route::get('/attendances/export', [AttendanceController::class, 'export'])->name('attendances.export');
    Route::get('/attendances/submit/{user}/{month}', [AttendanceController::class, 'submit'])->name('attendances.submit');
    Route::get('/attendances/approved/{user}/{month}', [AttendanceController::class, 'approved'])->name('attendances.approved');
    Route::get('/attendances/declined/{user}/{month}', [AttendanceController::class, 'declined'])->name('attendances.declined');
    Route::get('/attendances/hrapproved/{user}/{month}', [AttendanceController::class, 'hrapproved'])->name('attendances.hrapproved');
    Route::get('/attendances/hrdeclined/{user}/{month}', [AttendanceController::class, 'hrdeclined'])->name('attendances.hrdeclined');
    Route::get('/attendances/lmapproval/index', [AttendanceController::class, 'lmapproval'])->name('attendances.lmapproval');
    Route::get('/attendances/hrapproval/index', [AttendanceController::class, 'hrapproval'])->name('attendances.hrapproval');
    Route::resource('attendances', AttendanceController::class);

});

// Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
// Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
// Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
// Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
