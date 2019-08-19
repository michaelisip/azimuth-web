<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeUserPassword;
use App\Http\Requests\UpdateUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * View student profile
     *
     * @return view
     */
    public function index()
    {
        return view('user.profile', ['user' => Auth::user()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $user)
    {
        /**
         * TODO: Needs refactoring
         */

        $user = User::findOrFail($user);

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
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->avatar = $request->avatar ?: $user->avatar;
        $user->save();

        return back()->with('success', 'Successfully updated information!');
    }

    /**
     * Change User Password
     *
     * @param  \Illuminate\Http\Request  $request
     * @param App\User
     *
     * return view
     */
    public function changePassword(ChangeUserPassword $request, $user)
    {
        User::findOrFail($user)->update(['password' => $request->password]);

        return back()->with('success', 'Successfully changed password');
    }
}
