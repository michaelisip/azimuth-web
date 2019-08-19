<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Quiz;
use App\Http\Requests\AddNewQuiz;
use App\Imports\QuizzesImport;
use Maatwebsite\Excel\Facades\Excel;

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

        return back()->with('success', 'Successfully imported quizzes.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.quizzes.questions', [
            'quiz' => Quiz::findOrFail($id),
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
    public function update(Request $request, $id)
    {
        Quiz::findOrFail($id)->update($request->all());

        return back()->with('success', 'Successfully updated quiz');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Quiz::destroy($id);

        return redirect()->route('admin.quizzes.index')->with('success', 'Successfully deleted quiz.');
    }
}
