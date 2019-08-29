<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeAdminPassword;
use App\Http\Requests\UpdateAdminProfile;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    /**
     * view admin settings
     *
     * @return view
     */
    public function index()
    {
        return view('admin.settings', ['user' => Auth::user()]);
    }

    /**
     * Updating the application's name and/or logo
     *
     * @return back
     */
    public function updateApplication(Request $request, Application $application)
    {
        if ($request->has('logo')) {

            // Get image extension
            $logo = $request->logo;
            $ext = $logo->getClientOriginalExtension();

            // store in public folder
            $filename = uniqid() . '.' .$ext;
            $logo->storeAs('public/logos', $filename);

            // delete existing user image
            if (isset($application->logo) && $application->logo != 'default.jpg') {
                Storage::delete("/public/logos/" . $application->logo);
            }

            // assign to request
            $request->logo = $filename;
        }

        // update
        $application->name = $request->name;
        $application->logo = $request->logo ?: $application->logo;;
        $application->save();

        return back()->with('success', 'Successfully Updated Settings');
    }

    /**
     * Update admin profile
     *
     * @return back
     */
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
            if (isset($user->avatar) && $user->avatar != 'default.jpg') {
                Storage::delete("/public/avatars/" . $user->avatar);
            }

            // assign to request
            $request->avatar = $filename;
        }

        // update
        $user->name = $request->name;
        $user->email = $request->email;
        $user->avatar = $request->avatar ?: $user->avatar;
        $user->save();

        return back()->with('success', 'Successfully Updated Profile');
    }

    /**
     * changing password
     *
     * @return back
     */
    public function changePassword(ChangeAdminPassword $request, Admin $user)
    {
        $user->update(['password' => $request->password]);

        return back()->with('success', 'Successfully changed password');
    }
}
