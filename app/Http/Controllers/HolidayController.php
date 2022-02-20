<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holiday = Holiday::all();
        return view('admin.holidays.index', ['holidays' => $holiday]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.holidays.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|unique:holidays,name',
            'year' => 'required',

            'file' => 'required',
        ]);

        $path = $request->file('file')->storeAs('public/files', $request->name . '.pdf');

        $holiday = new Holiday();
        $holiday->name = $request->name;
        $holiday->year = $request->year;

        $holiday->path = $path;
        $holiday->save();

        $holiday = Holiday::all();
        return view('admin.holidays.index', ['holidays' => $holiday]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function show(Holiday $holiday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit(Holiday $holiday)
    {
        return view('admin.holidays.edit', ['holiday' => $holiday]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Holiday $holiday)
    {
        if (isset($request->file)) {
            $path = $request->file('file')->storeAs('public/files', $request->name . '.pdf');
            $holiday->path = $path;
        }

        $holiday->name = $request->name;
        $holiday->desc = $request->desc;
        $holiday->start_date = $request->start_date;
        $holiday->end_date = $request->end_date;

        $holiday->save();

        $holiday = Holiday::all();
        return view('admin.holidays.index', ['holidays' => $holiday]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday $holiday)
    {
        $file_path = public_path() . '/storage/files/' . $holiday->name . '.pdf';
        unlink($file_path);
        $holiday->delete();
        return redirect()->route('admin.holidays.index');
    }
}
