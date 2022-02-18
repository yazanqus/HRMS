<?php

namespace App\Providers;

use App\Models\Leave;
use App\Models\Overtime;
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

                        $leaves = Leave::whereIn('user_id', $subsets)->where('status', 'Pending LM Approval')->get();
                        $overtimes = Overtime::whereIn('user_id', $subsets)->where('status', 'Pending LM Approval')->get();
                        // if (count($leaves)) {
                        $numleaveapproval = count($leaves);
                        $numoverapproval = count($overtimes);
                        $numapproval = $numleaveapproval + $numoverapproval;

                        $hrleaves = Leave::where('status', 'Pending HR Approval')->get();
                        $hrovertimes = Overtime::where('status', 'Pending HR Approval')->get();
                        $numleavehrapproval = count($hrleaves);
                        $numoverhrapproval = count($hrovertimes);
                        $numhrapproval = $numleavehrapproval + $numoverhrapproval;
                        // dd($numapproval);

                        $view->with('numleaveapproval', $numleaveapproval)
                            ->with('numoverapproval', $numoverapproval)
                            ->with('numapproval', $numapproval)
                            ->with('numleavehrapproval', $numleavehrapproval)
                            ->with('numoverhrapproval', $numoverhrapproval)
                            ->with('numhrapproval', $numhrapproval);
                        // }
                    } else {
                        $view->with('numleaveapproval', '0')
                            ->with('numoverapproval', '0')
                            ->with('numapproval', '0')
                            ->with('numleavehrapproval', '0')
                            ->with('numoverhrapproval', '0')
                            ->with('numhrapproval', '0');
                    }
                }
            }

        }
        );
    }
}
