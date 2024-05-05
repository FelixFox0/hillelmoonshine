<?php

namespace App\Repositories;

use App\Dto\UserDto;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function all()
    {
        $users = DB::table('users')->get();
        return $users->map(function ($user) {
            return new UserDto($user->id, $user->name, $user->email);
        })->all();
    }
    public function findById($userId)
    {
        $userData = DB::table('users')->where('id', $userId)->first();
        return new UserDto($userData->id, $userData->name, $userData->email);
    }
}
