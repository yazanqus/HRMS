<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('admin.users.index', ['users' => $model->paginate(15)]);
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

        return redirect()->route('admin.users.index');

    }
}
