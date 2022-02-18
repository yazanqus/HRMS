<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Leavetype;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Kyslik\ColumnSortable\Sortable;

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

        $users = User::sortable();

        $users = User::query();
        if (request('term')) {
            $users->where('name', 'Like', '%' . request('term') . '%');
            $users->orderBy('name', 'DESC')->paginate(10);
        }

        if (request('id')) {
            $users->where('employee_number', 'Like', '%' . request('id') . '%');
            $users->orderBy('name', 'DESC')->paginate(10);
        }

        if (request('position')) {
            $users->where('position', 'Like', '%' . request('position') . '%');
            $users->orderBy('name', 'DESC')->paginate(10);
        }

        User::orderBy('employee_number')->pluck('name', 'position');
        $users = User::sortable();

        $variablee = '';

        return view('admin.users.index', ['users' => $users->paginate(15) , 'variablee' => $variablee]);
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
            'employee_number' => 'required',
            'birth_date',
            'position',
            'grade',
            // 'unit' => 'required',
            'joined_date' => 'required',
            'linemanager',
            'hradmin' => 'required',
            'email',
            'password' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->employee_number = $request->employee_number;
        $user->birth_date = $request->birth_date;
        $user->position = $request->position;
        $user->unit = $request->unit;
        $user->grade = $request->grade;
        $user->linemanager = $request->linemanager;
        $user->joined_date = $request->joined_date;
        $user->hradmin = $request->hradmin;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        // EmployeeCreated::dispatch($user);
        // listeners
        // create employee balance
        // set line manger
        //

        $day = date("d", strtotime($user->joined_date));
        $month = date("m", strtotime($user->joined_date));
        if ($day < '15') {

            $userannualleavebalance = (1.25 * (12 - $month + 1));

        }

        if ($day >= '15') {
            $userannualleavebalance = ((1.25 * (12 - $month)) + 0.5);
        }

        $annualleavehalfday = $userannualleavebalance * 2;

        // dd($userannualleavebalance);

        $leavetypes = Leavetype::all();
        foreach ($leavetypes as $leavetype) {

            if ($leavetype->name == "Annual leave") {
                $user->balances()->create([

                    'name' => $leavetype->name,
                    'value' => $userannualleavebalance,
                    'leavetype_id' => $leavetype->id,
                ]);

                // if ($leavetype->id = '1') {

                // $user->balances()->create([
                //     'leavetype_id' => $leavetype->id,
                //     'name' => $leavetype->name,
                //     'value' => $userannualleavebalance,
                // ]);

                // $user->balances()->create([
                //     'leavetype_id' => $leavetype->id,
                //     'name' => $leavetype->name,
                //     'value' => '5',
                // ]);
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
        // $user->balances()->create([
        //     'leavetype_id' => '2',
        //     'name' => 'Sick',
        //     'value' => '6',
        // ]);

        // $user->balances()->create([
        //     'leavetype_id' => '3',
        //     'name' => 'Annual - First half',
        //     'value' => '7',
        // ]);

        $setlinemenager = $request->linemanager;
        DB::table('users')->where('name', $setlinemenager)->update(['usertype_id' => '2']);

        return redirect()->route('admin.users.index');

    }

    public function show(User $user)
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
        ]);

    }

    public function edit(User $user)
    {
        // $balances = Balance::where('user_id', $user->id)->get();
        // $subsets = $balances->map(function ($balance) {
        //     return collect($balance->toArray())

        //         ->only(['value', 'leavetype_id'])
        //         ->all();
        // });
        // $final = $subsets->firstwhere('leavetype_id', '1');
        // $finalfinal = $final['value'];
        // return view('admin.users.edit', ['user' => $user, 'balance' => $finalfinal]);
        $userss = User::all();
        return view('admin.users.edit', ['user' => $user, 'userss' => $userss]);

    }

    public function update(User $user, Request $request)
    {
        $request->validate([

            'name' => 'required',
            'employee_number' => 'required',
            'birth_date',
            'position',
            // 'unit' => 'required',
            'grade',
            'joined_date' => 'required',
            'linemanager',
            'hradmin',
            'password',
            // hradminrole?
            // staffrole?
        ]);
        // dd($request);
        // $user->password = Hash::make($request->password);

        // $user->update($request->all());

        $user->name = $request->name;
        $user->employee_number = $request->employee_number;
        $user->birth_date = $request->birth_date;
        $user->position = $request->position;
        // $user->unit = $request->unit;
        $user->grade = $request->grade;
        $user->linemanager = $request->linemanager;
        $user->joined_date = $request->joined_date;
        $user->hradmin = $request->hradmin;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        $day = date("d", strtotime($user->joined_date));
        $month = date("m", strtotime($user->joined_date));
        if ($day < '15') {

            $userannualleavebalance = (1.25 * (12 - $month + 1));

        }

        if ($day >= '15') {
            $userannualleavebalance = ((1.25 * (12 - $month)) + 0.5);
        }

        // dd($userannualleavebalance);

        // $balances = Balance::where('user_id', $user->id)->get();
        // dd($balances);

        $user->balances()->where('name', 'Annual leave')->update([
            'value' => $userannualleavebalance,
        ]);

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
        $user->delete();
        return redirect()->route('admin.users.index');
    }
}
