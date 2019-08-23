<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("quiz_id");
            $table->unsignedBigInteger("question_id");
            $table->unsignedBigInteger("score_id");
            $table->enum("student_answer", ['a', 'b', 'c', 'd']);
            // felt like this isn't necessary cause we can get the correct answer using question_id
            // $table->enum("correct_answer", ['a', 'b', 'c', 'd']);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign("user_id")
                    ->references('id')
                    ->on("users")
                    ->onDelete('cascade');
            $table->foreign("quiz_id")
                    ->references('id')
                    ->on("quizzes")
                    ->onDelete('cascade');
            $table->foreign("question_id")
                    ->references('id')
                    ->on("questions")
                    ->onDelete('cascade');
            $table->foreign("score_id")
                    ->references('id')
                    ->on("scores")
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
