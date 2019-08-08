<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
