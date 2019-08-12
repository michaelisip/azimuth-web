<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\API\UserUpdateRequest;
use App\User;

class UserController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function me(Request $request)
    {
        return $this->showOne($request->user());
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($user->isClean()) {
            return $this->errorResponse('You need to specify a different value to update.', 422);
        }

        $user->save();

        return $this->showOne($user);
    }
}