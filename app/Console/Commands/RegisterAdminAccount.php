<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Admin;
use Illuminate\Support\Facades\Hash;

class RegisterAdminAccount extends Command
{

    private $admin;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register new admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Admin $admin)
    {
        parent::__construct();

        $this->admin = $admin;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $details = $this->getDetails();
        $admin = $this->admin->createNewAdmin($details);

        $this->display($admin);
    }

    /**
     * Ask for admin details.
     *
     * @return array
     */
    private function getDetails() : array
    {
        $details['name'] = $this->ask('Name');
        $details['email'] = $this->ask('Email');
        $details['password'] = $this->secret('Password');
        $details['confirm_password'] = $this->secret('Confirm password');

        while (! $this->isValidPassword($details['password'], $details['confirm_password'])) {
            if (! $this->isRequiredLength($details['password'])) {
                $this->error('Password must be more that six characters');
            }
            if (! $this->isMatch($details['password'], $details['confirm_password'])) {
                $this->error('Password and Confirm password do not match');
            }

            $details['password'] = $this->secret('Password');
            $details['confirm_password'] = $this->secret('Confirm password');

        }

        $details['password'] = $details['password'];
        $details['confirm_password'] = $details['confirm_password'];

        return $details;
    }

    /**
     * Display created admin.
     *
     * @param array $admin
     * @return void
     */
    private function display(Admin $admin) : void
    {
        $headers = ['Name', 'Email'];
        $fields = [
            'Name' => $admin->name,
            'Email' => $admin->email,
        ];

        $this->info('Admin created');
        $this->table($headers, [$fields]);
    }

    /**
     * Check if password is vailid
     *
     * @param string $password
     * @param string $confirmPassword
     * @return boolean
     */
    private function isValidPassword(string $password, string $confirmPassword) : bool
    {
        return $this->isRequiredLength($password) &&
        $this->isMatch($password, $confirmPassword);
    }

    /**
     * Check if password and confirm password matches.
     *
     * @param string $password
     * @param string $confirmPassword
     * @return bool
     */
    private function isMatch(string $password, string $confirmPassword) : bool
    {
        return $password === $confirmPassword;
    }

    /**
     * Checks if password is longer than six characters.
     *
     * @param string $password
     * @return bool
     */

    private function isRequiredLength(string $password) : bool
    {
        return strlen($password) > 6;
    }
}
