<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'admin_id',
        'action'
    ];

    public static function log(Admin $admin, $action)
    {
        ActivityLog::create([
            'admin_id' => $admin->id,
            'action' => $action
        ]);

        return;
    }

    public function getNameAttribute()
    {
        $admin = Admin::findOrFail($this->admin_id);
        return $admin->name;
    }
}
