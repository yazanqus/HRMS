<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Exports\BalanceExport;
use App\Models\Attendance;
use App\Models\Balance;
use App\Models\Leave;
use App\Models\Leavetype;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Mail\Leave as MailLeave;
use App\Models\Overtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Framework\Constraint\IsFalse;

use function PHPUnit\Framework\isFalse;
use function PHPUnit\Framework\isNull;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $currentuser = Auth::user();
        if ($currentuser->office == "AO3")
        {
            $users = User::where('office','AO3')->get();
            $variablee = '';
            return view('admin.users.index', ['users' => $users, 'variablee' => $variablee, 'user' => $currentuser]);
        }

        elseif ($currentuser->office == "AO4")
        {
            $users = User::where('office','AO4')->get();
            $variablee = '';
            return view('admin.users.index', ['users' => $users, 'variablee' => $variablee, 'user' => $currentuser]);
        }
        elseif ($currentuser->office == "AO6")
        {
            $users = User::where('office','AO6')->get();
            $variablee = '';
            return view('admin.users.index', ['users' => $users, 'variablee' => $variablee, 'user' => $currentuser]);
        }
        elseif ($currentuser->office == "AO7")
        {
            $users = User::where('office','AO7')->get();
            $variablee = '';
            return view('admin.users.index', ['users' => $users, 'variablee' => $variablee, 'user' => $currentuser]);
        }
        else 
        {
            $users = User::all()->except(1);
            $variablee = '';
            return view('admin.users.index', ['users' => $users, 'variablee' => $variablee, 'user' => $currentuser]);
        }
  
    }

    public function create()
    {
        $users = User::all();
     
        return view('admin.users.create', ['users' => $users]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'employee_number' => 'required|unique:users,employee_number',
            'contract' => 'required',
            'birth_date',
            'grade' => 'required',
            'position',
            'department',
            'joined_date' => 'required',
            'office' => 'required',
            'linemanager',
            'hradmin',
            'email'  => 'required|email|unique:users,email',
            
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->employee_number = $request->employee_number;
        $user->contract = $request->contract;
        $user->birth_date = $request->birth_date;
        $user->position = $request->position;
        $user->office = $request->office;
        $user->department = $request->department;
        $user->grade = $request->grade;
        $user->linemanager = $request->linemanager;
        $user->joined_date = $request->joined_date;
        $user->hradmin = $request->hradmin;
        $user->email = $request->email;
        // $user->password = Hash::make($request->password);

        $user->save();




       

        $year = date("Y", strtotime($user->joined_date));
        $day = date("d", strtotime($user->joined_date));
        $month = date("m", strtotime($user->joined_date));
        $datenow = Carbon::now();
        $yearnow = $datenow->year;

        if ($user->contract == "Service")
        {
            if ($year < $yearnow) {
                $userannualleavebalance = '21';
            } else {
    
                if ($day < '15') {
                    $userannualleavebalance = (1.75 * (12 - $month + 1));
                }
    
                if ($day >= '15') {
                    $userannualleavebalance = ((1.75 * (12 - $month)) + 0.5);
                }
            }
        }

        else{

            if ($year < $yearnow) {
                $userannualleavebalance = '15';
            } else {
    
                if ($day < '15') {
                    $userannualleavebalance = (1.25 * (12 - $month + 1));
                }
    
                if ($day >= '15') {
                    $userannualleavebalance = ((1.25 * (12 - $month)) + 0.5);
                }
            }
        }

        $annualleavehalfday = $userannualleavebalance * 2;

        $leavetypes = Leavetype::all();
        foreach ($leavetypes as $leavetype) {

            if ($leavetype->name == "Annual leave") {
                $user->balances()->create([

                    'name' => $leavetype->name,
                    'value' => $userannualleavebalance,
                    'leavetype_id' => $leavetype->id,
                ]);

            } elseif ($leavetype->name == "Annual leave - First half") {
                $user->balances()->create([

                    'name' => $leavetype->name,
                    'value' => $annualleavehalfday,
                    'leavetype_id' => $leavetype->id,
                ]);

            } elseif ($leavetype->name == "Annual leave - Second half") {
                $user->balances()->create([

                    'name' => $leavetype->name,
                    'value' => $annualleavehalfday,
                    'leavetype_id' => $leavetype->id,
                ]);
            } else {
                $user->balances()->create([
                    'name' => $leavetype->name,
                    'value' => $leavetype->value,
                    'leavetype_id' => $leavetype->id,
                ]);
            }
        }

        $setlinemenager = $request->linemanager;
        DB::table('users')->where('name', $setlinemenager)->update(['usertype_id' => '2']);

        //-------------- start of attendance creation - commented for prod lunch of HR leave manamgenet ------------
        // $AttendstartDate = $request->joined_date;
        // $AttendendDate = '2022-12-31';
        // $period = CarbonPeriod::create($AttendstartDate, $AttendendDate);
        // foreach ($period as $date) {
        //     $dates[] = $date->format('d-m-Y');
        // }

        // foreach ($dates as $datesss) {
        //     $days[] = Carbon::parse($datesss)->dayName;
        // }

        // $whole = array_map(function ($dates, $days) {
        //     return [
        //         'date' => $dates,
        //         'day' => $days,
        //     ];
        // }, $dates, $days);

        // foreach ($whole as $value) {

        //     $user->attendances()->create([

        //         'sign' => $value['day'],
        //         'day' => $value['date'],
        //         'year' => '2022',
        //     ]);
        // }

        // $user->attendances()
        //     ->where([
        //         ['day', 'LIKE', '%' . '-01-' . '%'],
        //     ])
        //     ->update(['month' => 'January']);
        // $user->attendances()
        //     ->where([
        //         ['day', 'LIKE', '%' . '-02-' . '%'],
        //     ])
        //     ->update(['month' => 'February']);
        // $user->attendances()
        //     ->where([
        //         ['day', 'LIKE', '%' . '-03-' . '%'],
        //     ])
        //     ->update(['month' => 'March']);
        // $user->attendances()
        //     ->where([
        //         ['day', 'LIKE', '%' . '-04-' . '%'],
        //     ])
        //     ->update(['month' => 'April']);
        // $user->attendances()
        //     ->where([
        //         ['day', 'LIKE', '%' . '-05-' . '%'],
        //     ])
        //     ->update(['month' => 'May']);
        // $user->attendances()
        //     ->where([
        //         ['day', 'LIKE', '%' . '-06-' . '%'],
        //     ])
        //     ->update(['month' => 'June']);
        // $user->attendances()
        //     ->where([
        //         ['day', 'LIKE', '%' . '-07-' . '%'],
        //     ])
        //     ->update(['month' => 'July']);
        // $user->attendances()
        //     ->where([
        //         ['day', 'LIKE', '%' . '-08-' . '%'],
        //     ])
        //     ->update(['month' => 'August']);
        // $user->attendances()
        //     ->where([
        //         ['day', 'LIKE', '%' . '-09-' . '%'],
        //     ])
        //     ->update(['month' => 'September']);
        // $user->attendances()
        //     ->where([
        //         ['day', 'LIKE', '%' . '-10-' . '%'],
        //     ])
        //     ->update(['month' => 'October']);
        // $user->attendances()
        //     ->where([
        //         ['day', 'LIKE', '%' . '-11-' . '%'],
        //     ])
        //     ->update(['month' => 'November']);
        // $user->attendances()
        //     ->where([
        //         ['day', 'LIKE', '%' . '-12-' . '%'],
        //     ])
        //     ->update(['month' => 'December']);

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {


        $hruser = Auth::user();
        // dd($hruser->office);

        if ($hruser->office == "AO3" || $hruser->office == "AO4" || $hruser->office == "AO6" || $hruser->office == "AO7")
        {
            if ($hruser->office !== $user->office)
            {
                abort(403);
            }
            else{
                
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
    
            $leave3 = $subsets->firstwhere('leavetype_id', '3');
            $balance3 = round($leave3['value'],3);
    
            $leave4 = $subsets->firstwhere('leavetype_id', '4');
            $balance4 = round($leave4['value'],3);
    
            $leave5 = $subsets->firstwhere('leavetype_id', '5');
            $balance5 = round($leave5['value'],3);
    
            $leave6 = $subsets->firstwhere('leavetype_id', '6');
            $balance6 = round($leave6['value'],3);
    
            $leave7 = $subsets->firstwhere('leavetype_id', '7');
            $balance7 = round($leave7['value'],3);
    
            $leave8 = $subsets->firstwhere('leavetype_id', '8');
            $balance8 = round($leave8['value'],3);
    
            $leave9 = $subsets->firstwhere('leavetype_id', '9');
            $balance9 = round($leave9['value'],3);
    
            $leave10 = $subsets->firstwhere('leavetype_id', '10');
            $balance10 = round($leave10['value'],3);
    
            $leave11 = $subsets->firstwhere('leavetype_id', '11');
            $balance11 = round($leave11['value'],3);
    
            $leave12 = $subsets->firstwhere('leavetype_id', '12');
            $balance12 = round($leave12['value'],3);
    
            // $leave13 = $subsets->firstwhere('leavetype_id', '13');
            // $balance13 = round($leave13['value'],3);
    
            // $leave14 = $subsets->firstwhere('leavetype_id', '14');
            // $balance14 = round($leave14['value'],3);
    
            $leave15 = $subsets->firstwhere('leavetype_id', '15');
            $balance15 = round($leave15['value'],3);
    
            // $leave16 = $subsets->firstwhere('leavetype_id', '16');
            // $balance16 = round($leave16['value'],3);
    
            // $leave17 = $subsets->firstwhere('leavetype_id', '17');
            // $balance17 = round($leave17['value'],3);
            $leave18 = $subsets->firstwhere('leavetype_id', '18');
            $balance18 = round($leave18['value'],3);

            $leaves = Leave::where('user_id', $user->id)->get();
            $overtimes = Overtime::where('user_id', $user->id)->get();
    
            return view('admin.users.show', [
                'user' => $user,
                'balance1' => $balance1,
                'balance2' => $balance2,
                'balance3' => $balance3,
                'balance4' => $balance4,
                'balance5' => $balance5,
                'balance6' => $balance6,
                'balance7' => $balance7,
                'balance8' => $balance8,
                'balance9' => $balance9,
                'balance10' => $balance10,
                'balance11' => $balance11,
                'balance12' => $balance12,
                'balance15' => $balance15,
                'balance18' => $balance18,
                'leaves'=> $leaves,
                'overtimes' => $overtimes,
            ]);
    
            }
        }

        else
        {
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
    
            $leave3 = $subsets->firstwhere('leavetype_id', '3');
            $balance3 = round($leave3['value'],3);
    
            $leave4 = $subsets->firstwhere('leavetype_id', '4');
            $balance4 = round($leave4['value'],3);
    
            $leave5 = $subsets->firstwhere('leavetype_id', '5');
            $balance5 = round($leave5['value'],3);
    
            $leave6 = $subsets->firstwhere('leavetype_id', '6');
            $balance6 = round($leave6['value'],3);
    
            $leave7 = $subsets->firstwhere('leavetype_id', '7');
            $balance7 = round($leave7['value'],3);
    
            $leave8 = $subsets->firstwhere('leavetype_id', '8');
            $balance8 = round($leave8['value'],3);
    
            $leave9 = $subsets->firstwhere('leavetype_id', '9');
            $balance9 = round($leave9['value'],3);
    
            $leave10 = $subsets->firstwhere('leavetype_id', '10');
            $balance10 = round($leave10['value'],3);
    
            $leave11 = $subsets->firstwhere('leavetype_id', '11');
            $balance11 = round($leave11['value'],3);
    
            $leave12 = $subsets->firstwhere('leavetype_id', '12');
            $balance12 = round($leave12['value'],3);
    
            // $leave13 = $subsets->firstwhere('leavetype_id', '13');
            // $balance13 = round($leave13['value'],3);
    
            // $leave14 = $subsets->firstwhere('leavetype_id', '14');
            // $balance14 = round($leave14['value'],3);
    
            $leave15 = $subsets->firstwhere('leavetype_id', '15');
            $balance15 = round($leave15['value'],3);
    
            // $leave16 = $subsets->firstwhere('leavetype_id', '16');
            // $balance16 = round($leave16['value'],3);
    
            // $leave17 = $subsets->firstwhere('leavetype_id', '17');
            // $balance17 = round($leave17['value'],3);
            $leave18 = $subsets->firstwhere('leavetype_id', '18');
            $balance18 = round($leave18['value'],3);
    
            $leaves = Leave::where('user_id', $user->id)->get();
            $overtimes = Overtime::where('user_id', $user->id)->get();

            return view('admin.users.show', [
                'user' => $user,
                'balance1' => $balance1,
                'balance2' => $balance2,
                'balance3' => $balance3,
                'balance4' => $balance4,
                'balance5' => $balance5,
                'balance6' => $balance6,
                'balance7' => $balance7,
                'balance8' => $balance8,
                'balance9' => $balance9,
                'balance10' => $balance10,
                'balance11' => $balance11,
                'balance12' => $balance12,
                'balance15' => $balance15,
                'balance18' => $balance18,
                'leaves'=> $leaves,
                'overtimes' => $overtimes,
            ]);
    
        }
        
    }

    public function edit(User $user)
    {

        $hruser = Auth::user();
        // dd($hruser->office);test

        if ($hruser->office == "AO3" || $hruser->office == "AO4" || $hruser->office == "AO6" || $hruser->office == "AO7")
        {
            if ($hruser->office !== $user->office)
            {
                abort(403);
            }

            else
            {
                $userss = User::all();
                $hruser = Auth::user();
                return view('admin.users.edit', ['user' => $user,  'hruser'=> $hruser, 'userss' => $userss]);
            }
        }

        else
        {
            $userss = User::all();
            $hruser = Auth::user();
            return view('admin.users.edit', ['user' => $user,  'hruser'=> $hruser, 'userss' => $userss]);
        }

        // $balances = Balance::where('user_id', $user->id)->get();
        // $subsets = $balances->map(function ($balance) {
        //     return collect($balance->toArray())

        //         ->only(['value', 'leavetype_id'])
        //         ->all();
        // });
        // $final = $subsets->firstwhere('leavetype_id', '1');
        // $finalfinal = $final['value'];
        // return view('admin.users.edit', ['user' => $user, 'balance' => $finalfinal]);
        // -------------------- old edit function without security url settings -------------------------------------
        // $userss = User::all();
        // $hruser = Auth::user();
        // return view('admin.users.edit', ['user' => $user,  'hruser'=> $hruser, 'userss' => $userss]);

    }

    public function update(User $user, Request $request)
    {
        $request->validate([

            'name' => 'required',
            'employee_number' => 'required|unique:users,employee_number,' . $user->id,
            // 'employee_number' => 'required',
            'contract' ,
            'birth_date',
            'position',
            'office',
            'department',
            'grade'=> 'required',
            'joined_date' => 'required',
            'linemanager',
            'hradmin',
            'email'  => 'required|email|unique:users,email,' .$user->id,
            'password',
            // hradminrole?
            // staffrole?
        ]);
        $hruser = Auth::user();
        // dd($request);
        // $user->password = Hash::make($request->password);

        // $user->update($request->all());

        $user->name = $request->name;
        $user->employee_number = $request->employee_number;
        $user->birth_date = $request->birth_date;
        $user->contract = $request->contract;
        $user->position = $request->position;
        if ($hruser->office == "AO2")
        {
            $user->office = $request->office;

        }
        $user->department = $request->department;
        $user->grade = $request->grade;
        $user->linemanager = $request->linemanager;
        $user->joined_date = $request->joined_date;
        if ($hruser->superadmin == "yes")
        {
            $user->hradmin = $request->hradmin;

        }
        
        $user->email = $request->email;

        if (isset($request->password)) {

            $user->password = Hash::make($request->password);
        }

        $user->save();

        $checkifuserhasleave = Leave::where([
            ['user_id', $user->id],
            ['status', 'Approved']])->get();

        // dd($checkifuserhasleave);

        // disable the update of balances when updating user (joined date/contract) after a while (after he has at least one approved leave)
        if ($checkifuserhasleave->isEmpty() && $user->id > 208) {

            $yearr = date("Y", strtotime($user->joined_date));
            $dayy = date("d", strtotime($user->joined_date));
            $monthh = date("m", strtotime($user->joined_date));
            $datenoww = Carbon::now();
            $yearnoww = $datenoww->year;
            // dd($yearnoww);


            if ($user->contract == "Service")
            {
                if ($yearr < $yearnoww) {
                    $userannualleavebalancee = '21';
                } else {
    
                    if ($dayy < '15') {
    
                        $userannualleavebalancee = (1.75 * (12 - $monthh + 1));
    
                    }
    
                    if ($dayy >= '15') {
                        $userannualleavebalancee = ((1.75 * (12 - $monthh)) + 0.5);
                    }
                }
            }

            else
            {
                if ($yearr < $yearnoww) {
                    $userannualleavebalancee = '15';
                } else {
    
                    if ($dayy < '15') {
    
                        $userannualleavebalancee = (1.25 * (12 - $monthh + 1));
    
                    }
    
                    if ($dayy >= '15') {
                        $userannualleavebalancee = ((1.25 * (12 - $monthh)) + 0.5);
                    }
                }
    
            }
            

           
            $annualleavehalfdayy = $userannualleavebalancee * 2;

            // dd($userannualleavebalancee);

            // $balances = Balance::where('user_id', $user->id)->get();
            // dd($balances);

            $user->balances()->where('name', 'Annual leave')->update([
                'value' => $userannualleavebalancee,
            ]);

            $user->balances()->where('name', 'Annual leave - First half')->update([
                'value' => $annualleavehalfdayy,
            ]);

            $user->balances()->where('name', 'Annual leave - Second half')->update([
                'value' => $annualleavehalfdayy,
            ]);
        }

        // $leavetypes = Leavetype::all();
        // foreach ($leavetypes as $leavetype) {

        //     if ($leavetype->name == "Annual leave") {
        //         $user->balances()->create([

        //             'name' => $leavetype->name,
        //             'value' => $userannualleavebalance,
        //             'leavetype_id' => $leavetype->id,
        //         ]);

        //         // if ($leavetype->id = '1') {

        //         // $user->balances()->create([
        //         //     'leavetype_id' => $leavetype->id,
        //         //     'name' => $leavetype->name,
        //         //     'value' => $userannualleavebalance,
        //         // ]);

        //         // $user->balances()->create([
        //         //     'leavetype_id' => $leavetype->id,
        //         //     'name' => $leavetype->name,
        //         //     'value' => '5',
        //         // ]);
        //     } else {
        //         $user->balances()->create([
        //             'name' => $leavetype->name,
        //             'value' => $leavetype->value,
        //             'leavetype_id' => $leavetype->id,
        //         ]);
        //     }
        // }

        $setlinemenager = $request->linemanager;
        DB::table('users')->where('name', $setlinemenager)->update(['usertype_id' => '2']);

        return redirect()->route('admin.users.index');

    }

    public function destroy(User $user)
    {
        $user->leaves()->delete();
        $user->overtimes()->delete();
        $user->balances()->delete();
        $user->delete();
        return redirect()->route('admin.users.index');
    }

    public function removesuspend($id)
    {
        $user = User::find($id);
        $user->status = 'active';
        $user->save();

        return redirect()->route('admin.users.index');

    }

    public function suspend($id)
    {
        $user = User::find($id);
        $user->status = 'suspended';
        $user->save();

        return redirect()->route('admin.users.index');

    }

    public function balanceedit(User $user)
    {

        $hruser = Auth::user();
        if ($hruser->superadmin !== 'yes')
        {
            abort(403);

        }
        else
        {

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
    
            $leave3 = $subsets->firstwhere('leavetype_id', '3');
            $balance3 = $leave3['value'];
    
            $leave4 = $subsets->firstwhere('leavetype_id', '4');
            $balance4 = $leave4['value'];
    
            $leave5 = $subsets->firstwhere('leavetype_id', '5');
            $balance5 = $leave5['value'];
    
            $leave6 = $subsets->firstwhere('leavetype_id', '6');
            $balance6 = $leave6['value'];
    
            $leave7 = $subsets->firstwhere('leavetype_id', '7');
            $balance7 = $leave7['value'];
    
            $leave8 = $subsets->firstwhere('leavetype_id', '8');
            $balance8 = $leave8['value'];
    
            $leave9 = $subsets->firstwhere('leavetype_id', '9');
            $balance9 = $leave9['value'];
    
            $leave10 = $subsets->firstwhere('leavetype_id', '10');
            $balance10 = $leave10['value'];
    
            $leave11 = $subsets->firstwhere('leavetype_id', '11');
            $balance11 = $leave11['value'];
    
            $leave12 = $subsets->firstwhere('leavetype_id', '12');
            $balance12 = $leave12['value'];
    
            // $leave13 = $subsets->firstwhere('leavetype_id', '13');
            // $balance13 = $leave13['value'];
    
            // $leave14 = $subsets->firstwhere('leavetype_id', '14');
            // $balance14 = $leave14['value'];
    
            $leave15 = $subsets->firstwhere('leavetype_id', '15');
            $balance15 = $leave15['value'];
    
            // $leave16 = $subsets->firstwhere('leavetype_id', '16');
            // $balance16 = $leave16['value'];
    
            // $leave17 = $subsets->firstwhere('leavetype_id', '17');
            // $balance17 = $leave17['value'];
            $leave18 = $subsets->firstwhere('leavetype_id', '18');
            $balance18 = $leave18['value'];
    
            return view('admin.users.balanceedit', [
                'user' => $user,
                'balance1' => $balance1,
                'balance2' => $balance2,
                'balance3' => $balance3,
                'balance4' => $balance4,
                'balance5' => $balance5,
                'balance6' => $balance6,
                'balance7' => $balance7,
                'balance8' => $balance8,
                'balance9' => $balance9,
                'balance10' => $balance10,
                'balance11' => $balance11,
                'balance12' => $balance12,
                'balance15' => $balance15,
                'balance18' => $balance18,
            ]);
        }


    }

    public function balanceupdate(Request $request, User $user)
    {

        $request->validate([

            // 'name' => 'required',
            // 'employee_number',
            // 'birth_date',
            // 'position',
            // // 'unit' => 'required',
            // 'joined_date' => 'required',
            // 'linemanager',
            // 'hradmin',
            // 'password',
            // hradminrole?
            // staffrole?
        ]);

        Balance::where([
            ['user_id', $user->id],
            ['leavetype_id', '1'],
        ])->first()?->update(['value' => $request->annual_leave]);

        Balance::where([
            ['user_id', $user->id],
            ['leavetype_id', '2'],
        ])->first()?->update(['value' => $request->sick_leave]);

        Balance::where([
            ['user_id', $user->id],
            ['leavetype_id', '3'],
        ])->first()?->update(['value' => $request->sick_leave30]);

        Balance::where([
            ['user_id', $user->id],
            ['leavetype_id', '4'],
        ])->first()?->update(['value' => $request->sick_leave20]);

        Balance::where([
            ['user_id', $user->id],
            ['leavetype_id', '5'],
        ])->first()?->update(['value' => $request->marriage_leave]);

        Balance::where([
            ['user_id', $user->id],
            ['leavetype_id', '6'],
        ])->first()?->update(['value' => $request->compassion_first]);

        Balance::where([
            ['user_id', $user->id],
            ['leavetype_id', '7'],
        ])->first()?->update(['value' => $request->compassion_second]);

        Balance::where([
            ['user_id', $user->id],
            ['leavetype_id', '8'],
        ])->first()?->update(['value' => $request->maternity_leave]);

        Balance::where([
            ['user_id', $user->id],
            ['leavetype_id', '9'],
        ])->first()?->update(['value' => $request->paternity_leave]);

        Balance::where([
            ['user_id', $user->id],
            ['leavetype_id', '12'],
        ])->first()?->update(['value' => $request->welfare_leave]);

        Balance::where([
            ['user_id', $user->id],
            ['leavetype_id', '15'],
        ])->first()?->update(['value' => $request->unpaid_leave]);

        Balance::where([
            ['user_id', $user->id],
            ['leavetype_id', '18'],
        ])->first()?->update(['value' => $request->compansention]);

        // $user->save();

        return redirect()->route('admin.users.index');

    }

    // public function staffattendance(User $user, Attendance $attendance)
    // {

    //     if ($attendance->month == 'January') {
    //         $search = '-01-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if

    //     if ($attendance->month == 'February') {
    //         $search = '-02-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if

    //     if ($attendance->month == 'March') {
    //         $search = '-03-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if

    //     if ($attendance->month == 'April') {
    //         $search = '-04-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'May') {
    //         $search = '-05-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'June') {
    //         $search = '-06-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'July') {
    //         $search = '-07-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'August') {
    //         $search = '-08-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'September') {
    //         $search = '-09-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'October') {
    //         $search = '-10-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'November') {
    //         $search = '-11-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'December') {
    //         $search = '-12-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if

    //     return view('admin.users.staffattendance', ['user' => $user,
    //         'attendances' => $attendances]);
    // }

    // public function allstaffattendance(Attendance $attendance, User $user)
    // {

    //     $attendances = Attendance::whereNull('user_id')->get();
    //     return view('admin.users.allstaffattendance', ['user' => $user,
    //         'attendances' => $attendances]);

    // }

    // public function mystaffattendance(User $user, Attendance $attendance)
    // {

    //     if ($attendance->month == 'January') {
    //         $monthshow = 'January';
    //         $search = '-01-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if

    //     if ($attendance->month == 'February') {
    //         $monthshow = 'February';
    //         $search = '-02-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if

    //     if ($attendance->month == 'March') {
    //         $monthshow = 'March';
    //         $search = '-03-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if

    //     if ($attendance->month == 'April') {
    //         $monthshow = 'April';
    //         $search = '-04-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'May') {
    //         $monthshow = 'May';
    //         $search = '-05-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'June') {
    //         $monthshow = 'June';
    //         $search = '-06-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'July') {
    //         $monthshow = 'July';
    //         $search = '-07-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'August') {
    //         $monthshow = 'August';
    //         $search = '-08-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'September') {
    //         $monthshow = 'September';
    //         $search = '-09-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'October') {
    //         $monthshow = 'October';
    //         $search = '-10-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'November') {
    //         $monthshow = 'November';
    //         $search = '-11-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if
    //     if ($attendance->month == 'December') {
    //         $monthshow = 'December';
    //         $search = '-12-';
    //         $attendances = Attendance::where([
    //             ['user_id', $user->id],
    //             ['day', 'LIKE', '%' . $search . '%']])->get();
    //     } //end januaury if

    //     return view('staffleaves.staffattendance', ['user' => $user,
    //         'month' => $monthshow,
    //         'attendances' => $attendances]);
    // }

    // public function myallstaffattendance(Attendance $attendance, User $user)
    // {

    //     $attendances = Attendance::whereNull('user_id')->get();
    //     return view('staffleaves.allstaffattendance', ['user' => $user,
    //         'attendances' => $attendances]);

    // }

    public function export()
    {

        $hruser = Auth::user();
        if ($hruser->office == "AO2")
        {
            $users= User::all()->except(1);

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
                $users= User::wherein('id', $hrsubsets)->get(); 
    }
        }

        
        return Excel::download(new UsersExport($users), 'users.xlsx');
    }




    public function balanceexport(Request $request)
    {

        $request->validate([
       
            'start_date',
            // 'end_date' => 'nullable|after_or_equal:start_date',
            // 'leavetype' => 'required',
            'name',
           
        ]);


        $hruser = Auth::user();


        $name= $request->name;
        $contract = $request->contract;
        $start_date=$request->start_date;
        // $end_date=$request->end_date;
        $office = $request->office;
        // $permission = $request->permission;
        $staffstatus = $request->staffstatus;
        $linemanager = $request->linemanager;
        // $leavetype=$request->leavetype;
        // dd($request->name);
        // dd($leavetype);

        if ($start_date == Null)
        {
            $start_datee = "2015-01-01";
        }

        else if ($start_date !== Null)
        {
            $start_datee = $start_date;
        }

     

        if ($staffstatus == Null)
        {
            $staffstatuse = ['active','suspended'];
        }

        else if ($staffstatus !== Null)
        {
            $staffstatuse = $staffstatus;
        }

        if ($office == Null)
        {
            $officee = ['AO2','AO3','AO4','AO6','AO7'];
        }

        else if ($office !== Null)
        {
            $officee = $office;
        }
        
        // if ($permission == Null)
        // {
        //     $permissione = ['yes',Null,'no'];
            
        // }

        // else if ($permission !== Null)
        // {
        //     $permissione = $permission;
        // }


        if ($contract == Null)
        {
            $contracte = ['Regular','Service','NA'];
        }

        else if ($contract !== Null)
        {
            $contracte = $contract;
        }


        if ($request->name == null)
        {   
            if ($hruser->office == "AO2") {

                $staffwithsameoffice = User::whereIn('office',$officee)->WhereIn('status', $staffstatuse)->get();
                if (count($staffwithsameoffice))
                {
                    $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                        return collect($staffwithsameoffice->toArray())
                            ->only(['id'])
                            ->all();
                    });
                    $users = User::whereIn('id', $hrsubsets)->where([
                        ['joined_date', '>=', $start_datee],
                
                    ])->WhereIn('contract', $contracte)->get();
                    
                }  
                
                
               
            }

            else {
                $staffwithsameoffice = User::where('office',$hruser->office)->WhereIn('status', $staffstatuse)->get();
            if (count($staffwithsameoffice))
            {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                    return collect($staffwithsameoffice->toArray())
                        ->only(['id'])
                        ->all();
                });
                $users = User::whereIn('id', $hrsubsets)->where([
                    ['joined_date', '>=', $start_datee],
            
                ])->WhereIn('contract', $contracte)->get();
                
            }       
            }
            

        }
        else
        {
            $userid = User::where('name',$name)->value('id');
        
  
 
            $users = User::where([
    
                ['id', $userid],
                ['joined_date', '>=', $start_datee],
        
    
    
            ])->WhereIn('contract', $contracte)->get();
        }

        if ($linemanager !== Null)
        {
            $staff = User::where('linemanager', $linemanager)->get();
            if (count($staff))
            {
            $subsets = $staff->map(function ($staff) {
                return collect($staff->toArray())

                    ->only(['id'])
                    ->all();
            });

            $users = User::whereIn('id', $subsets)->where([
                ['joined_date', '>=', $start_datee],
        
            ])->WhereIn('contract', $contracte)->get();
        }

        else {
            $users = User::where([
                ['joined_date', '>=', $start_datee],
        
            ])->WhereIn('contract', $contracte)->Where('status', "nothing to show")->get();
        }

        

        }

        return Excel::download(new BalanceExport($users), 'balances.xlsx');
        

    }

    public function import(Request $request)
    {
        $file = $request->file('file');

    Excel::import(new UsersImport, $request->file('file'));
       
    }

    public function importshow()
    {
        return view('admin.users.importshow');
    }

    public function createbalance()
    {
        $users = User::all()->except(1);

        $leavetypes = Leavetype::all();

        foreach ($users as $user)
        {
            foreach ($leavetypes as $leavetype) {

              
                    $user->balances()->create([
                        'name' => $leavetype->name,
                        'value' => $leavetype->value,
                        'leavetype_id' => $leavetype->id,
                    ]);
                
            }
        }

        return redirect()->route('admin.users.index');
        
    }


    public function search(Request $request)
    {

        $request->validate([
       
            'start_date',
            // 'end_date' => 'nullable|after_or_equal:start_date',
            // 'leavetype' => 'required',
            'name',
           
        ]);


        $hruser = Auth::user();


        $name= $request->name;
        $contract = $request->contract;
        $start_date=$request->start_date;
        // $end_date=$request->end_date;
        $office = $request->office;
        // $permission = $request->permission;
        $staffstatus = $request->staffstatus;
        $linemanager = $request->linemanager;
        // $leavetype=$request->leavetype;
        // dd($request->name);
        // dd($leavetype);

        if ($start_date == Null)
        {
            $start_datee = "2015-01-01";
        }

        else if ($start_date !== Null)
        {
            $start_datee = $start_date;
        }

     

        if ($staffstatus == Null)
        {
            $staffstatuse = ['active','suspended'];
        }

        else if ($staffstatus !== Null)
        {
            $staffstatuse = $staffstatus;
        }

        if ($office == Null)
        {
            $officee = ['AO2','AO3','AO4','AO6','AO7'];
        }

        else if ($office !== Null)
        {
            $officee = $office;
        }
        
        // if ($permission == Null)
        // {
        //     $permissione = ['yes',Null,'no'];
            
        // }

        // else if ($permission !== Null)
        // {
        //     $permissione = $permission;
        // }


        if ($contract == Null)
        {
            $contracte = ['Regular','Service','NA'];
        }

        else if ($contract !== Null)
        {
            $contracte = $contract;
        }


        if ($request->name == null)
        {   
            if ($hruser->office == "AO2") {

                $staffwithsameoffice = User::whereIn('office',$officee)->WhereIn('status', $staffstatuse)->get();
                if (count($staffwithsameoffice))
                {
                    $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                        return collect($staffwithsameoffice->toArray())
                            ->only(['id'])
                            ->all();
                    });
                    $users = User::whereIn('id', $hrsubsets)->where([
                        ['joined_date', '>=', $start_datee],
                
                    ])->WhereIn('contract', $contracte)->get();
                    
                }  
                
                
               
            }

            else {
                $staffwithsameoffice = User::where('office',$hruser->office)->WhereIn('status', $staffstatuse)->get();
            if (count($staffwithsameoffice))
            {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                    return collect($staffwithsameoffice->toArray())
                        ->only(['id'])
                        ->all();
                });
                $users = User::whereIn('id', $hrsubsets)->where([
                    ['joined_date', '>=', $start_datee],
            
                ])->WhereIn('contract', $contracte)->get();
                
            }       
            }
            

        }
        else
        {
            $userid = User::where('name',$name)->value('id');
        
  
 
            $users = User::where([
    
                ['id', $userid],
                ['joined_date', '>=', $start_datee],
        
    
    
            ])->WhereIn('contract', $contracte)->get();
        }

        if ($linemanager !== Null)
        {
            $staff = User::where('linemanager', $linemanager)->get();
            if (count($staff))
            {
            $subsets = $staff->map(function ($staff) {
                return collect($staff->toArray())

                    ->only(['id'])
                    ->all();
            });

            $users = User::whereIn('id', $subsets)->where([
                ['joined_date', '>=', $start_datee],
        
            ])->WhereIn('contract', $contracte)->get();
        }

        else {
            $users = User::where([
                ['joined_date', '>=', $start_datee],
        
            ])->WhereIn('contract', $contracte)->Where('status', "nothing to show")->get();
        }

        

        }

        switch ($request->input('action')) {
            case 'view':
                return view('admin.users.search', ['users' => $users, 'name'=>$name,'start_date' =>$start_datee]);
                break;
    
            case 'excel':
                return Excel::download(new UsersExport($users), 'users.xlsx');
                break;
            }
        

        
    }


}
