<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Question;
use App\Quiz;
use App\User;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke()
    {
        return view('admin.index', [
            'studentsCount' => User::count(),
            'quizzesCount' => Quiz::count(),
            'questionsCount' => Question::count()
        ]);
    }

}
