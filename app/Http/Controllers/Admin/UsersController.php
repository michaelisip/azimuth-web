<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\AddNewUser;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Http\Requests\UpdateUser;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users', ['users' => User::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddNewUser $request)
    {
        User::create($request->all());

        return back()->with('success', 'User created successfully.');
    }

    /**
     * Import data from an excel file
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        try {
            Excel::import(new UsersImport, request()->file('file'));
        } catch(\Maatwebsite\Excel\Validators\ValidationException $e){
            return back()->with('import', $e->failures());
        }

        return back()->with('success', 'Successfully imported students.');
    }

    /**
     * Export data from database
     *
     * @return back
     */
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->all());

        return back()->with('success', 'Successfully updated user.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return back()->with('success', 'Successfully deleted user.');
    }
}
