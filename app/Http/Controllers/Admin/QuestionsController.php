<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddNewQuestion;
use App\Quiz;
use App\Question;
use App\Imports\QuestionsImport;
use Maatwebsite\Excel\Facades\Excel;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($quiz)
    {
        if($quiz == 'all') {
            return view('admin.questions.index');
        }

        return redirect()->route('admin.questions.show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddNewQuestion $request, $quiz)
    {
        $question = new Question($request->all());

        $existingQuiz = Quiz::findOrFail($quiz);
        $existingQuiz->questions()->save($question);

        return back()->with('success', 'Successfully added question.');
    }

    /**
     * Import data from an excel file
     * 
     * @return \Illuminate\Http\Response
     */
    public function import($quiz)
    {
        try {
            Excel::import(new QuestionsImport($quiz), request()->file('file'));
        } catch(\Maatwebsite\Excel\Validators\ValidationException $e){
            return back()->with('import', $e->failures());
        }

        return back()->with('success', 'Successfully imported quesitons.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.quizzes.questions');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($quiz, $id)
    {
        Question::destroy($id);

        return back()->with('success', 'Successfully deleted question.');
    }
}
