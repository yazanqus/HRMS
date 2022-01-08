<?php

namespace App\Http\Controllers;

use App\Models\Leavetype;
use App\Models\User;
use Illuminate\Http\Request;
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
        return view('admin.users.create');
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
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->employee_number = $request->employee_number;
        $user->birth_date = $request->birth_date;
        $user->position = $request->position;
        $user->unit = $request->unit;
        $user->joined_date = $request->joined_date;
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
        foreach ($leavetypes as $leavetype) {if ($leavetype->id = '1') {

            $user->balances()->create([
                'leavetype_id' => $leavetype->id,
                'name' => $leavetype->name,
                'value' => $userannualleavebalance,
            ]);

            $user->balances()->create([
                'leavetype_id' => $leavetype->id,
                'name' => $leavetype->name,
                'value' => '5',
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

        return redirect()->route('admin.users.index');

    }
}
