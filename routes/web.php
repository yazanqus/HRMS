<?php
namespace App\Http\Middleware;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\UserController;
use App\Models\Balance;
use App\Models\Leave;
use App\Models\Overtime;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::group(['middleware' => ['auth', 'checkstatus', 'hradmin'], 'prefix' => '/admin', 'as' => 'admin.'], function () {
    Route::get('/leaves/export', [LeaveController::class, 'export'])->name('leaves.export');
    Route::get('/overtimes/export', [OvertimeController::class, 'export'])->name('overtimes.export');
    Route::get('allstaffleaves', function () {
        $leaves = Leave::all();
        return view('admin.allstaffleaves.index', ['leaves' => $leaves]);
    })->name('allstaffleaves.index');

    Route::get('allstaffovertimes', function () {
        $overtimes = Overtime::all();
        return view('admin.allstaffovertimes.index', ['overtimes' => $overtimes]);
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

});

Route::group(['middleware' => ['auth', 'checkstatus', 'hradmin']], function () {
    Route::get('leaves/hrapproval', function () {

        // dd($staff);

        // dd($subsets);
        // $leaves = Leave::whereIn([
        //     ['user_id', $subsets],
        //     ['status', 'Pending Approval'],
        // ])->get();

        $leaves = Leave::where('status', 'Pending HR Approval')->get();
        // $leaves = Leave::where('Status', 'Pending Approval')->get();
        // dd($leaves);
        if (count($leaves)) {
            return view('hrapproval.leaves.index', ['leaves' => $leaves]);

        } else {

            $leavess = Leave::where([

                ['status', 'no staff under this line manager'],
            ])->get();
            // dd($leavess);

            return view('hrapproval.leaves.index', ['leaves' => $leavess]);
        }

    })->name('leaves.hrapproval');

    Route::get('overtimes/hrapproval', function () {

        // dd($staff);

        // dd($subsets);
        // $leaves = Leave::whereIn([
        //     ['user_id', $subsets],
        //     ['status', 'Pending Approval'],
        // ])->get();

        $overtimes = Overtime::where('status', 'Pending HR Approval')->get();
        // $leaves = Leave::where('Status', 'Pending Approval')->get();
        // dd($leaves);
        if (count($overtimes)) {
            return view('hrapproval.overtimes.index', ['overtimes' => $overtimes]);

        } else {

            $overtimess = Overtime::where([

                ['status', 'no staff under this line manager'],
            ])->get();
            // dd($leavess);

            return view('hrapproval.overtimes.index', ['overtimes' => $overtimess]);
        }

    })->name('overtimes.hrapproval');

});

Route::get('login/okta', [LoginController::class, 'redirectToProvider'])->name('login-okta');
Route::get('login/okta/callback', [LoginController::class, 'handleProviderCallback']);

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
        $balance1 = $leave1['value'];

        $leave2 = $subsets->firstwhere('leavetype_id', '2');
        $balance2 = $leave2['value'];

        $leave12 = $subsets->firstwhere('leavetype_id', '12');
        $balance12 = $leave12['value'];

        $leave18 = $subsets->firstwhere('leavetype_id', '18');
        $balance18 = $leave18['value'];

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
            // dd($subsets);
            // $leaves = Leave::whereIn([
            //     ['user_id', $subsets],
            //     ['status', 'Pending Approval'],
            // ])->get();

            $leaves = Leave::whereIn('user_id', $subsets)->where('status', 'Pending LM Approval')->get();
            // $leaves = Leave::where('Status', 'Pending Approval')->get();
            // dd($leaves);
            if (count($leaves)) {
                return view('approval.leaves.index', ['leaves' => $leaves]);

            } else {

                $leavess = Leave::where([
                    ['user_id', $user->id],
                    ['status', 'no staff under this line manager'],
                ])->get();
                // dd($leavess);

                return view('approval.leaves.index', ['leaves' => $leavess]);
            }

        } else {
            $leavess = Leave::where([
                ['user_id', $user->id],
                ['status', 'no staff under this line manager'],
            ])->get();
            // dd($leavess);

            return view('approval.leaves.index', ['leaves' => $leavess]);
        }

    })->name('leaves.approval');

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

            $overtimes = Overtime::whereIn('user_id', $subsets)->where('status', 'Pending LM Approval')->get();
            // $leaves = Leave::where('Status', 'Pending Approval')->get();
            // dd($leaves);
            if (count($overtimes)) {
                return view('approval.overtimes.index', ['overtimes' => $overtimes]);

            } else {

                $overtimess = Overtime::where([
                    ['user_id', $user->id],
                    ['status', 'no staff under this line manager'],
                ])->get();
                // dd($leavess);

                return view('approval.overtimes.index', ['overtimes' => $overtimess]);
            }

        } else {
            $overtimess = Overtime::where([
                ['user_id', $user->id],
                ['status', 'no staff under this line manager'],
            ])->get();
            // dd($leavess);

            return view('approval.overtimes.index', ['overtimes' => $overtimess]);
        }

    })->name('overtimes.approval');

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

    Route::get('table-list', function () {
        return view('pages.table_list');
    })->name('table');

    Route::get('typography', function () {
        return view('pages.typography');
    })->name('typography');

    Route::get('icons', function () {
        return view('pages.icons');
    })->name('icons');

    Route::get('map', function () {
        return view('pages.map');
    })->name('map');

    Route::get('notifications', function () {
        return view('pages.notifications');
    })->name('notifications');

    Route::get('rtl-support', function () {
        return view('pages.language');
    })->name('language');

    Route::get('upgrade', function () {
        return view('pages.upgrade');
    })->name('upgrade');

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
    Route::get('/leaves/approved/{id}', [LeaveController::class, 'approved'])->name('leaves.approved');
    Route::get('/leaves/declined/{id}', [LeaveController::class, 'declined'])->name('leaves.declined');
    Route::get('/leaves/hrapproved/{id}', [LeaveController::class, 'hrapproved'])->name('leaves.hrapproved');
    Route::get('/leaves/hrdeclined/{id}', [LeaveController::class, 'hrdeclined'])->name('leaves.hrdeclined');
});

Route::group(['middleware' => ['auth', 'checkstatus']], function () {
    Route::resource('overtimes', OvertimeController::class);
    Route::get('/overtimes/approved/{id}', [OvertimeController::class, 'approved'])->name('overtimes.approved');
    Route::get('/overtimes/declined/{id}', [OvertimeController::class, 'declined'])->name('overtimes.declined');
    Route::get('/overtimes/hrapproved/{id}', [OvertimeController::class, 'hrapproved'])->name('overtimes.hrapproved');
    Route::get('/overtimes/hrdeclined/{id}', [OvertimeController::class, 'hrdeclined'])->name('overtimes.hrdeclined');
});

// Route::group(['middleware' => 'auth'], function () {
//     Route::resource('overtimes', OvertimeController::class);
//     // Route::get('/leaves/approved/{id}', [LeaveController::class, 'approved'])->name('leaves.approved');
//     // Route::get('/leaves/declined/{id}', [LeaveController::class, 'declined'])->name('leaves.declined');
// });

// Route::resource('leaves', LeaveController::class);
