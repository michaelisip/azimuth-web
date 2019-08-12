<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'quiz_id', 'score',
    ];

    /**
     * Eloquent Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
