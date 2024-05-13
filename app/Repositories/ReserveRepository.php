<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ReserveRepository implements ReserveRepositoryInterface
{
    public function getAllReservesByUserId($userId)
    {
        return DB::table('reserves')
            ->where('user_id', '=', $userId)
            ->get();
    }

    public function addUserReserve($userId, $clientName, $clientPhone, $startTime, $endTime)
    {
        DB::table('reserves')
            ->insert([
                'user_id' => $userId,
                'name' => $clientName,
                'phone' => $clientPhone,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);
    }
}
