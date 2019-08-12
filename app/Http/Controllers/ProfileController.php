<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * View student profile
     *
     * @return view
     */
    public function index()
    {
        return view('user.profile', ['user' => Auth::user()]);
    }
}
