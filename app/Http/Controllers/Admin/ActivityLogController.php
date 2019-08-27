<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class ActivityLogController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $logs = ActivityLog::latest()->get();

        if ($request->ajax()) {
            return DataTables::of($logs)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->name;
                })
                ->addColumn('action', function($row){
                    return ucfirst($row->action);
                })
                ->addColumn('created_at', function($row){
                    return $row->created_at->diffForHumans();
                })
                ->make(true);
        }

        return view('admin.logs', ['logs' => $logs]);
    }
}
