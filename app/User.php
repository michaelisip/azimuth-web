<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'avatar', 'email', 'mobile', 'address', 'password', 'google2fa_secret'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'google2fa_secret'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Ecrypt the user's google_2fa secret.
     *
     * @param  string  $value
     * @return string
     */
    public function setGoogle2faSecretAttribute($value)
    {
        $this->attributes['google2fa_secret'] = encrypt($value);
    }

    /**
     * Decrypt the user's google_2fa secret.
     *
     * @param  string  $value
     * @return string
     */
    public function getGoogle2faSecretAttribute($value)
    {
        if (!is_null($value)) return decrypt($value);

        return null;
    }

    /**
     * Encrypt user password on create
     *
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Eloquent Relationships
     *
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Function Helpers
     *
     * TODO: Refactor
     */

    public function hasStudentAnsweredQuiz($id) : bool
    {
        if($this->scores()->where('quiz_id', $id)->first()) {
            return true;
        }
        return false;
    }

    public function latestQuiz()
    {
        return $this->scores()->latest()->first();
    }

    public function highestQuizScore()
    {
        return $this->scores()->orderBy('score', 'DESC')->first();
    }

    public function lowestQuizScore()
    {
        return $this->scores()->orderBy('score', 'ASC')->first();
    }

    public function QuizScore($id) : int
    {
        $score = Score::where([
            'user_id' => Auth::user()->id,
            'quiz_id' => $id
            ])->value('score');

        return $score ?: 0;
    }

    public function scopeQuizScores($query, $id)
    {
        return $this->scores()->where('quiz_id', $id)->latest();
    }

    /**
    * Override parent boot and Call deleting event
    * Delete child student scores and answers when student is to be deleted
    *
    * @return void
    */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($instance) {
            $instance->scores->each->delete();
            $instance->answers->each->delete();
        });
    }
}
