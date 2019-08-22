<?php

use App\Answer;
use App\Quiz;
use App\Score;
use App\User;
use Illuminate\Database\Seeder;

class ScoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $choices = [
            'a',
            'b',
            'c',
            'd'
        ];

        foreach(Quiz::all() as $quiz) {

            foreach (User::inRandomOrder()->take(20)->get() as $user) {

                $userCorrect = 0;

                foreach ($quiz->questions as $question) {

                    $useAnswer = Answer::create([
                        'user_id' => $user->id,
                        'quiz_id' => $quiz->id,
                        'question_id' => $question->id,
                        'student_answer' => $choices[array_rand($choices)]
                    ]);

                    if ($useAnswer->student_answer == $question->answer) {
                        ++$userCorrect;
                    }

                }

                Score::create([
                    'user_id' => $user->id,
                    'quiz_id' => $quiz->id,
                    'score' => $userCorrect
                ]);
            }

        }

    }
}
