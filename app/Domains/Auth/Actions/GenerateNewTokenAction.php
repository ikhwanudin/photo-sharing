<?php

namespace App\Domains\Auth\Actions;

use App\Models\User;
use Illuminate\Http\Request;

class GenerateNewTokenAction
{
    public function __invoke(
        User $user,
        string  $token_name = 'auth_token'
    )
    {
        $token = $user->createToken($token_name);

        return $token->plainTextToken;
    }
}
