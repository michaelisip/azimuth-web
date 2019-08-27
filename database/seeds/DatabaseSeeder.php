<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(AdminSeeder::class);
        // $this->call(QuizQuestionsSeeder::class);
        // $this->call(ScoresSeeder::class);
    }
}
