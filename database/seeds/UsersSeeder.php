<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = 'password';

        User::create([
            'name' => 'User Azimuth',
            'email' => 'user@info.com',
            'email_verified_at' => now(),
            'password' => Hash::make($password),
        ]);

        factory(App\User::class, 100)->create();
    }
}
