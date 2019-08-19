<?php

use Illuminate\Database\Seeder;

class QuizQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Quiz::class, 5)->create()->each(function($quiz){
            $quiz->questions()->saveMany(factory(App\Question::class, 10)->make());
        });
    }
}
