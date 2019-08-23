<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Question extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question', 'a', 'b', 'c', 'd', 'answer', 'answer_explanation'
    ];

    /**
     * Eloquent Relationship
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function studentAnswer($studentId, $quizId, $scoreId)
    {
        $studentAnswer = Answer::where([
            'user_id' => $studentId,
            'quiz_id' => $quizId,
            'question_id' => $this->id,
            'score_id' => $scoreId
        ])->value('student_answer');

        return $studentAnswer ?: 'No Answer';
    }
}
