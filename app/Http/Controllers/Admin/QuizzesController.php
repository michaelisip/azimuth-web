<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLog;
use App\Exports\QuestionsExport;
use App\Exports\QuizzesExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Quiz;
use App\Http\Requests\AddNewQuiz;
use App\Imports\QuizzesImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;

class QuizzesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.quizzes.index', ['quizzes' => Quiz::paginate(6)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddNewQuiz $request)
    {
        Quiz::create($request->all());

        ActivityLog::log(Auth::guard('admin')->user(), "added a new quiz '{$request->title}'");

        return back()->with('success', 'Successfull added quiz.');
    }

    /**
     * Import data from an excel file
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        try {
            Excel::import(new QuizzesImport, request()->file('file'));
        } catch(\Maatwebsite\Excel\Validators\ValidationException $e){
            return back()->with('import', $e->failures());
        }

        ActivityLog::log(Auth::guard('admin')->user(), 'imported new quizzes');

        return back()->with('success', 'Successfully imported quizzes.');
    }

    /**
     * Export data from database
     *
     * @return back
     */
    public function export()
    {
        ActivityLog::log(Auth::guard('admin')->user(), 'exported quizzes');

        return Excel::download(new QuizzesExport, 'quizzes.xlsx');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Quiz $quiz)
    {
        if ($request->ajax()) {
            return DataTables::of($quiz->questions)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =
                            '<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#view-' . $row->id . '">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit-' . $row->id . '">
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

        return view('admin.quizzes.questions', [
            'quiz' => $quiz,
            'quizzes' => Quiz::select(['title', 'id'])->get()
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        $quiz->update($request->all());

        ActivityLog::log(Auth::guard('admin')->user(), "updated '{$quiz->title}'");

        return back()->with('success', 'Successfully updated quiz');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        ActivityLog::log(Auth::guard('admin')->user(), "deleted '{$quiz->title}'");

        return redirect()->route('admin.quizzes.index')->with('success', 'Successfully deleted quiz.');
    }
}
