<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{

    public function createAppliation()
    {
        if($this->all() < 1) {
            $this->insert();
        }
    }
}
