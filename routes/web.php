<?php

use App\Http\Middleware\PreventUserFromAdminAccess;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/**
 *  User Routes
 */

Route::group(['prefix' => ''], function () {

    // Route::view('', 'welcome');
    Route::redirect('', 'home');

    // Authentication
    Auth::routes();
    Route::get('/complete-registration', 'Auth\RegisterController@completeRegistration');
    Route::group(['middleware' => ['2fa']], function () {
        Route::post('2fa', function () {
            return redirect(URL()->previous());
        })->name('2fa');
    });

    Route::get('/home', 'HomeController@index')->name('home');

    /**
     * Practice Mode
     */
    Route::get('/quiz/{quiz}/practice-mode', 'PracticeController@index')->name('practice-mode');
    Route::post('/quiz/practice-mode/question/check', 'PracticeController@check')->name('check');

    /**
     * Quiz
     */
    Route::get('/quiz/{quiz}', 'QuizController@index')->name('quiz');
    Route::post('/quiz/question/check', 'QuizController@check')->name('answer');

    /**
     * Results
     */
    Route::get('/quiz/{quiz}/score', 'QuizController@score')->name('score');

    // Profile
    Route::get('profile', 'ProfileController@index')->name('profile');

});


// ==================================================================================

/**
 * Admin Routes
 */
Route::name('admin.')->group(function(){
    Route::group(['prefix' => 'admin'], function () {
        Route::namespace('Admin')->group(function () {

            // Authentication
            Route::get('login', 'LoginController@showLoginForm')->name('login');
            Route::post('login', 'LoginController@login')->name('login.submit');
            Route::post('logout', 'LoginController@logout')->name('logout');

            // Admin Functions
            Route::group(['middleware' => ['auth:admin']], function () {

                Route::view('/', 'admin.index')->name('dashboard');

                Route::resources([
                    'users' => 'UsersController',
                    'quizzes' => 'QuizzesController',
                    'quizzes/{quiz}/questions' => 'QuestionsController',
                ]);

                // imports
                Route::post('users/import', 'UsersController@import')->name('users.import');
                Route::post('quizzes/import', 'QuizzesController@import')->name('quizzes.import');
                Route::post('quizzes/{quiz}/questions/import', 'QuestionsController@import')->name('questions.import');

                // Reports
                Route::name('reports.')->group(function(){
                    Route::get('reports', 'ReportController@viewReports')->name('index');
                    Route::get('reports/top-students', 'ReportController@viewTopStudents')->name('top-students');
                    Route::get('reports/quiz/{quiz}', 'ReportController@viewQuizScores')->name('quiz');
                    Route::get('reports/student/{user}/scores', 'ReportController@viewStudentScores')->name('student-scores');
                });
            });
        });
    });
});
