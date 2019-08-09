<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;
use App\Question;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', '2fa']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', ['quizzes' => Quiz::with('questions')->get()]);
    }

    public function practiceMode($quiz)
    {
        return view('user.practice_mode', ['quiz' => Quiz::findOrFail($quiz)]);
    }

    public function check(Request $request)
    {

        $correct = Question::where([
            'quiz_id' => $request->quiz_id,
            'id' => $request->question_id])->value('answer');

        if ($correct == $request->student_answer) {
            return response()->json(['result' => 'correct']);
        }

        return response()->json(['result' => 'wrong']);
    }
}
