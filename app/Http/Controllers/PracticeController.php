<?php

namespace App\Http\Controllers;

use App\Question;
use App\Quiz;
use Illuminate\Http\Request;

class PracticeController extends Controller
{
    /**
     * View the quiz on practice mode
     *
     * @return view
     */
    public function index($quiz)
    {
        return view('user.practice_mode', ['quiz' => Quiz::findOrFail($quiz)]);
    }

    /**
     * Check if user's answer is correct
     *
     * @return json
     */
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
