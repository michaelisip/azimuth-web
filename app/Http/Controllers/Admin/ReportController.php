<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Quiz;
use App\User;

class ReportController extends Controller
{
    public function viewReports()
    {
        return view('admin.reports.index', ['users' => User::all()]);
    }

    public function viewTopStudents()
    {
        return view('admin.reports.top-students', ['quizzes' => Quiz::all()]);
    }

    public function viewQuizScores($quiz)
    {
        return view('admin.reports.quiz-scores', ['quiz' => Quiz::findOrFail($quiz)]);
    }

    public function viewStudentScores($user)
    {
        return view('admin.reports.student-scores', [
            'user' => User::findOrFail($user),
            'quizzes' => Quiz::all()]);
    }

}
