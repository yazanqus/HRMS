<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $policy = Policy::all();
        // $user = Auth::user();

        return view('admin.policies.index', ['policies' => $policy]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.policies.create');
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

            'name' => 'required|unique:policies,name',
            'desc',
            'created_date' => 'required',
            'lastupdate_date' => 'required',
            'file' => 'required',
        ]);

        $path = $request->file('file')->storeAs('public/files', $request->name . '.pdf');

        $policy = new Policy();
        $policy->name = $request->name;
        $policy->desc = $request->desc;
        $policy->created_date = $request->created_date;
        $policy->lastupdate_date = $request->lastupdate_date;
        $policy->path = $path;
        $policy->save();

        $policy = Policy::all();
        return view('admin.policies.index', ['policies' => $policy]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function show(Policy $policy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function edit(Policy $policy)
    {

        return view('admin.policies.edit', ['policy' => $policy]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Policy $policy)
    {

        if (isset($request->file)) {
            $path = $request->file('file')->storeAs('public/files', $request->name . '.pdf');
            $policy->path = $path;
        }

        $policy->name = $request->name;
        $policy->desc = $request->desc;
        $policy->created_date = $request->created_date;
        $policy->lastupdate_date = $request->lastupdate_date;

        $policy->save();

        $policy = Policy::all();
        return view('admin.policies.index', ['policies' => $policy]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Policy $policy)
    {
        // File::delete($policy->name);
        // File::delete(public_path("files/{{$policy->name}} . '.pdf'"));
        $file_path = public_path() . '/storage/files/' . $policy->name . '.pdf';
        unlink($file_path);
        $policy->delete();
        return redirect()->route('admin.policies.index');
    }
}
