<?php

namespace App\Domains\Auth\Actions;

use App\Models\User;

class GenerateNewTokenAction
{
    public function __invoke(
        User $user,
        string $token_name = 'auth_token'
    ) {
        $token = $user->createToken($token_name);

        return $token->plainTextToken;
    }
}
