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

    /**
   * Override parent boot and Call deleting event
   *
   * @return void
   */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($instance) {
            $instance->questions->each->delete();
        });
    }
}
