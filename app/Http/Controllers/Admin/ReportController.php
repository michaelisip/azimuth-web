<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Quiz;
use App\User;
use DataTables;

class ReportController extends Controller
{
    public function viewReports(Request $request)
    {
        $users = User::latest()->get();

        if ($request->ajax()) {
            return DataTables::of($users)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        if (!$row->scores->isEmpty()) {
                            $btn =
                                '<a href="' . route("admin.reports.student-scores", $row->id) . '" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> &nbsp; View Reports
                                </a>';
                            return $btn;
                        }
                    })
                    ->addColumn('quizzes_taken', function($row){
                        return $row->scores->count() > 0 ? $row->scores->count() : '<i>None</i>';
                    })
                    ->addColumn('last_quiz_taken', function($row){
                        return isset($row->latestQuiz()->created_at) ? $row->latestQuiz()->created_at->diffForHumans() : "<i>Hasn't Taken Any Quiz Yet</i>";
                    })
                    ->addColumn('highest_quiz_score', function($row){
                        return $row->highestQuizScore()->score ?? "<i>Hasn't Taken Any Quiz Yet</i>";
                    })
                    ->rawColumns(['action', 'quizzes_taken', 'last_quiz_taken', 'highest_quiz_score'])
                ->make(true);
        }

        return view('admin.reports.index', ['users' => $users]);
    }

    public function viewTopStudents()
    {
        return view('admin.reports.top-students', ['quizzes' => Quiz::paginate(8)]);
    }

    public function viewQuizScores(Request $request, $quiz)
    {
        $quiz = Quiz::findOrFail($quiz);

        if ($request->ajax()) {
            return DataTables::of($quiz->scores)
                    ->addIndexColumn()
                    ->addColumn('student_name', function($row){
                        return $row->user->name;
                    })
                    ->addColumn('correct_answers', function($row){
                        return $row->score;
                    })
                    ->addColumn('total_points', function($row){
                        return $row->score * $row->quiz->points_per_question;
                    })
                    ->addColumn('taken_when', function($row){
                        return $row->created_at->diffForHumans();
                    })
                    ->rawColumns(['action', 'correct_answers', 'total_points', 'taken_when'])
                ->make(true);
        }

        return view('admin.reports.quiz-scores', ['quiz' => $quiz]);
    }

    public function viewStudentScores(Request $request, $user, $quiz = null)
    {
        $user = User::findOrFail($user);
        $quizzes = Quiz::paginate(10);

        if ($request->ajax() && !is_null($quiz)) {

            $quizQuestions = Quiz::findOrFail($quiz)->questions;

            return DataTables::of($quizQuestions)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =
                            '<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#view-' . $row->id . '">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit-'. $row->id .'">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-' . $row->id .'">
                                <i class="fas fa-trash"></i>
                            </button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.reports.student-scores', [
            'user' => $user,
            'quizzes' => $quizzes]);
    }

}
