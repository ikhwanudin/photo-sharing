<?php

namespace App\Domains\Auth\Controllers;

use App\Domains\Auth\Actions\GenerateNewTokenAction;
use App\Domains\Auth\Resources\UserAuthResource;
use App\Domains\Utils\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class LoginUserController
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json(
                    Response::fail(message: 'Invalid login details'),
                    401
                );
        }

        $user = User::where('email', $request->email)->first();
        $user->token = (new GenerateNewTokenAction)($user);

        return new UserAuthResource($user);
    }
}
