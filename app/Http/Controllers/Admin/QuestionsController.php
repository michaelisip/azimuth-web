<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLog;
use App\Exports\QuestionsExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Quiz;
use App\Question;
use App\Imports\QuestionsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\AddUpdateQuestion;
use Illuminate\Support\Facades\Auth;

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
            return view('admin.questions.index' , [
                'questions' => Question::all(),
                'quizzes' => Quiz::select(['title', 'id'])->get()]);
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
    public function store(AddUpdateQuestion $request, $quiz)
    {
        $question = new Question($request->all());

        /**
         * TO DO: Refactor this from the questions.index blade
         * I couldn't pass the quiz id parameter to route action so I just used the quiz_id from form select
         */
        if (strpos(url()->previous(), 'all') && isset($request->quiz_id)) {
            $quiz = $request->quiz_id;
        }

        $existingQuiz = Quiz::findOrFail($quiz);
        $existingQuiz->questions()->save($question);

        ActivityLog::log(Auth::guard('admin')->user(), "added some questions to '{$existingQuiz->title}'");

        return back()->with('success', 'Successfully added question.');
    }

    /**
     * Import data from an excel file
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request, $quiz)
    {

        /**
         * TO DO: Refactor this from the questions.index blade
         * I couldn't pass the quiz id parameter to route action so I just used the quiz_id from form select
         */
        if (strpos(url()->previous(), 'all') && isset($request->quiz_id)) {
            $quiz = $request->quiz_id;
        }

        try {
            Excel::import(new QuestionsImport($quiz), request()->file('file'));
        } catch(\Maatwebsite\Excel\Validators\ValidationException $e){
            return back()->with('import', $e->failures());
        }

        ActivityLog::log(Auth::guard('admin')->user(), "imported questions");

        return back()->with('success', 'Successfully imported quesitons.');
    }

    /**
     * Import data from an excel file
     *
     * @return back
     */
    public function export(Quiz $quiz)
    {
        $quizName = $quiz->value('title');

        ActivityLog::log(Auth::guard('admin')->user(), "exported questions of '{$quizName}'");

        return Excel::download(new QuestionsExport($quiz->id), $quizName . ' - questions.xlsx');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddUpdateQuestion $request, $id)
    {
        $question = Question::findOrFail($id);

        $question->update($request->all());

        ActivityLog::log(Auth::guard('admin')->user(), "updated '{$question->question}'");

        return back()->with('success', 'Successfully updated question.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($quiz, Question $question)
    {
        $question->delete();

        ActivityLog::log(Auth::guard('admin')->user(), "deleted '{$question->question}'");

        return back()->with('success', 'Successfully deleted question.');
    }
}
