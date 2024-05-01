<?php

namespace App\Repositories;
use App\Models\User;

class RegisterRepository
{
    public function checkMail(string $mail): bool
    {
        $user = User::where('mail', '=', $mail)->first();
        if (isset($user->mail)) {
            return true;
        }

        return false;
    }
}
