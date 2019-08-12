<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'quiz_id', 'question_id', 'student_answer',
        // 'correct_answer',
    ];

    /**
     * Eloquent Relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
