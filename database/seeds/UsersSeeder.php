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
        $user = User::firstOrCreate([
            'email' => 'user@info.com'],[
            'name' => 'User Azimuth',
            'email_verified_at' => now(),
            'password' => 'password',
        ]);

        factory(App\User::class, 10000)->create();
    }
}
