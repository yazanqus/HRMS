<?php

namespace App\Console;

use App\Models\Balance;
use App\Models\Comlist;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $comlists = Comlist::whereNull('expired_date')->get();
          

            foreach($comlists as $comlist)
            {
                $userid = $comlist->user_id;
                $y = floatval($comlist->hours);
    
                $datenow = Carbon::now();
                $comlistcreatedate = new DateTime($comlist->created_at);
                $dateenow = new DateTime($datenow);
                $intervall = $comlistcreatedate->diff($dateenow);
                $probationdays = $intervall->format('%a');
    
                if ($probationdays > '90')
                {  
                    $comlist->expired_date=$datenow;
                    $comlist->save();
    
                    $x = Balance::where([
                        ['user_id', '1'],
                        ['leavetype_id', '18'],
                    ])->pluck('value')->first();
    
                    if ($x == '0')

                    {
                        $comlist->status="Used";
                        
                        $comlist->save();

                    }
                    else if ($x >= $y)
                    {
                        $newbalance = $x - $y;
                        $comlist->status="fulllost";
                        $comlist->expired_value=$y;
                        $comlist->save();
                        Balance::where([
                            ['user_id', $userid],
                            ['leavetype_id', '18'],
                        ])->first()?->update(['value' => $newbalance]);
                    }
    
                    else 
                    {
                        $comlist->status="partiallost";
                        $comlist->expired_value=$x;
                        $comlist->save();
                        Balance::where([
                            ['user_id', $userid],
                            ['leavetype_id', '18'],
                        ])->first()?->update(['value' => '0']);
                    }
                       
                }
            }
        })->everyMinute();



      
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
