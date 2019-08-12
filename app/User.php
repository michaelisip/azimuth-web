<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'mobile', 'address', 'password', 'google2fa_secret'
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
     * Eloquent Relationships
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function quizAnswered($id) : bool
    {
        if(Auth::user()->scores()->where('quiz_id', $id)->first()) {
            return true;
        }

        return false;
    }

    public function QuizScore($id) : int
    {
        return Score::where([
            'user_id' => Auth::user()->id,
            'quiz_id' => $id
            ])->value('score');
    }
}
