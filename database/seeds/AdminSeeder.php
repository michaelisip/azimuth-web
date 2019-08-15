<?php

use Illuminate\Database\Seeder;
use App\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::firstOrCreate([
            'name' => 'Admin Azimuth',
            'email' => 'admin@info.com',
            'password' => 'password'
        ]);


        if (!($admin->application)) {
            $admin->application()->create();
        }
    }
}
