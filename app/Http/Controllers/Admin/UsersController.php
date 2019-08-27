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
use DataTables;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::latest()->get();

        if ($request->ajax()) {
            return DataTables::of($users)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =
                            '<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit-' . $row->id . '">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-' . $row->id . '">
                                <i class="fas fa-trash"></i>
                            </button>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.users', ['users' => $users]);
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
