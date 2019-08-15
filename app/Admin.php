<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    //
    use Notifiable;

    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'avatar', 'email', 'password', 'google2fa_secret'
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
     * Eloquent Relationship
     */
    public function application()
    {
        return $this->hasOne(Application::class);
    }

    /**
     * Create admin.
     *
     * @param array $details
     * @return array
     */
    public function createNewAdmin(array $details) : self
    {
        $user = new self($details);
        $user->save();

        return $user;
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
    * Override parent boot and Call deleting event
    * Delete child student scores and answers when student is to be deleted
    *
    * @return void
    */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($instance) {
            $instance->application->delete();
        });
    }

}
