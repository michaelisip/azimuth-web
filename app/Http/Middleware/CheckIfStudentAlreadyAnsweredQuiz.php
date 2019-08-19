<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfStudentAlreadyAnsweredQuiz
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $quiz_id = $request->route('quiz');

        if (Auth::user()->hasStudentAnsweredQuiz($quiz_id)) {
            abort(403, 'You already answered this quiz.');
        }

        return $next($request);
    }
}
