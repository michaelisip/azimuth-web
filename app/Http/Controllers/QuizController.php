<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Middleware\CheckIfStudentAlreadyAnsweredQuiz;
use App\Question;
use App\Quiz;
use App\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{

    /**
     * Prevent students from accessing the quiz questions again
     */
    public function __construct()
    {
        // Commented since student can now retake a quiz
        // $this->middleware('quiz')->only('index');
        $this->middleware('auth');
    }

    /**
     * View the quiz questions
     *
     * @return view
     */
    public function index($quiz)
    {
        $this->initializeStudentScore($quiz);

        return view('user.quiz', ['quiz' => Quiz::with('questions')->findOrFail($quiz)]);
    }

    /**
     * Initialize student's score when viewing the quiz questions
     *
     * @return void
     */
    public function initializeStudentScore($quiz)
    {
        Auth::user()->scores()->create(['quiz_id' => $quiz]);

        return;
    }

    /**
     * Check if user's answer is correct
     *
     * @return json
     */
    public function check(Request $request)
    {
        // Get the correct answer
        $correct = Question::where([
            'quiz_id' => $request->quiz_id,
            'id' => $request->question_id])->value('answer');

        // Fetch currect user and current quiz attempt
        $user = Auth::user();
        $userScore = $user->scores()->where('quiz_id', $request->quiz_id)->latest()->first();

        // save user answer
        $user->answers()->create([
            'quiz_id' => $request->quiz_id,
            'question_id' => $request->question_id,
            'student_answer' => $request->student_answer,
            'score_id' => $userScore->id
        ]);

        // Increment user score if correct
        if ($correct == $request->student_answer) {
            $userScore->increment('score');
            return response()->json(['result' => 'correct']);
        }

        return response()->json(['result' => 'wrong']);
    }

    /**
     * View user score
     *
     * @return view
     */
    public function score($quiz)
    {
        return view('user.result', ['quiz' => Quiz::findOrfail($quiz)]);
    }
}
