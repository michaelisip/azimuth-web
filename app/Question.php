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

    public function studentAnswer($id)
    {
        return Answer::where([
            'user_id' => Auth::user()->id,
            'quiz_id' => $id,
            'question_id' => $this->id
        ])->value('student_answer');
    }
}
