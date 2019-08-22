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
        factory(App\Quiz::class, rand(5, 10))->create()->each(function($quiz){
            $quiz->questions()->saveMany(factory(App\Question::class, rand(10, 50))->make());
        });
    }
}
