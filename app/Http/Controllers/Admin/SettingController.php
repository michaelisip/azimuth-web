<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeAdminPassword;
use App\Http\Requests\UpdateAdminProfile;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings', ['user' => Auth::user()]);
    }

    public function updateProfile(UpdateAdminProfile $request, Admin $user)
    {
        if ($request->has('avatar')) {

            // Get image extension
            $avatar = $request->avatar;
            $ext = $avatar->getClientOriginalExtension();

            // store in public folder
            $filename = uniqid() . '.' .$ext;
            $avatar->storeAs('public/avatars', $filename);

            // delete existing user image
            if (isset($user->avatar)) {
                Storage::delete("/public/avatars/" . $user->avatar);
            }

            // assign to request
            $request->avatar = $filename;
        }

        // update
        $user->name = $request->name;
        $user->email = $request->email;
        $user->avatar = $request->avatar;
        $user->save();

        return back()->with('success', 'Successfully Updated Profile');
    }

    public function changePassword(ChangeAdminPassword $request, Admin $user)
    {
        $user->update(['password' => $request->password]);

        return back()->with('success', 'Successfully changed password');
    }
}
