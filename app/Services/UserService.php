<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function append_token_to_user($user, $token): array {
        return array_merge(['token' => $token->plainTextToken], $user->toArray());
    }
}
