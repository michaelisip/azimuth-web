<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'points_per_question', 'timer'
    ];

    /**
     * Eloquent Relationships
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    /**
   * Override parent boot and Call deleting event
   * Delete child questions and scores when quiz is to be deleted
   *
   * @return void
   */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($instance) {
            $instance->questions->each->delete();
            $instance->scores->each->delete();
        });
    }

    public function highestScores()
    {
        return $this->scores()->orderBy('score', 'DESC')->get();
    }

    public function lowestScores()
    {
        return $this->scores()->orderBy('score', 'ASC')->get();
    }
}
