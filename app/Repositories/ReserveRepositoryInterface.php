<?php

namespace App\Repositories;

interface ReserveRepositoryInterface
{
    public function getAllReservesByUserId($userId);

    public function addUserReserve($userId, $clientName, $clientPhone, $startTime, $endTime);

}
