<?php

use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\UserController;
use App\Models\Balance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('dashboard');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Auth::routes();

// Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {

    Route::get('welcome', function () {
        $user = Auth::user();
        $balances = Balance::where('user_id', $user->id)->get();
        $subsets = $balances->map(function ($balance) {
            return collect($balance->toArray())

                ->only(['value', 'leavetype_id'])
                ->all();
        });
        $final = $subsets->firstwhere('leavetype_id', '1');
        $finalfinal = $final['value'];
        return view('dashboard', ['user' => $user, 'balance' => $finalfinal]);
    })->name('welcome');

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
});

// Route::group(['middleware' => 'auth'], function () {
//     Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
//     Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
//     Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
//     Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
// });

Route::group(['middleware' => 'auth', 'prefix' => '/admin', 'as' => 'admin.'], function () {
    Route::resource('users', UserController::class);
});

Route::group(['middleware' => 'auth', 'prefix' => '/admin', 'as' => 'admin.'], function () {
    Route::resource('policies', PolicyController::class);
});

Route::group(['middleware' => 'auth', 'prefix' => '/admin', 'as' => 'admin.'], function () {
    Route::resource('holidays', HolidayController::class);
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('leaves', LeaveController::class);
});

// Route::resource('leaves', LeaveController::class);
