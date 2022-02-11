<?php

namespace App\Providers;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer('*', function ($view) {

            if ($view->getName() != "auth.login") {
                if (Auth::check()) {

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

                        $leaves = Leave::whereIn('user_id', $subsets)->where('status', 'Pending Approval')->get();
                        // if (count($leaves)) {
                        $numapproval = count($leaves);
                        // dd($numapproval);
                        $view->with('numapproval', $numapproval);
                        // }
                    }
                }
            }

        }
        );
    }
}
