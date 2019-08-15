<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
