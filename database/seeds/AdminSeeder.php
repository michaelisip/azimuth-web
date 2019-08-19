<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\Application;
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
            'name' => 'Admin Azimuth'],[
            'email' => 'admin@info.com',
            'password' => 'password'
        ]);

        if (Application::count() < 1) {
            Application::create();
        }
    }
}
