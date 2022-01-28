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

        return view('admin.users.index', ['users' => $users->paginate(15)]);
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
            'birth_date' => 'required',
            'position' => 'required',
            'unit' => 'required',
            'joined_date' => 'required',
            'linemanager' => 'required',
            'hradmin' => 'required',
            'password' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->employee_number = $request->employee_number;
        $user->birth_date = $request->birth_date;
        $user->position = $request->position;
        $user->unit = $request->unit;
        $user->linemanager = $request->linemanager;
        $user->joined_date = $request->joined_date;
        $user->hradmin = $request->hradmin;
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
        $final = $subsets->firstwhere('leavetype_id', '1');
        $finalfinal = $final['value'];
        return view('admin.users.show', ['user' => $user, 'balance' => $finalfinal]);

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
            'birth_date' => 'required',
            'position' => 'required',
            'unit' => 'required',
            'grade' => 'required',
            'joined_date' => 'required',
            'linemanager' => 'required',
            'hradmin',
            'password',
            // hradminrole?
            // staffrole?
        ]);
        // dd($request);
        $user->password = Hash::make($request->password);

        $user->update($request->all());

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
}
