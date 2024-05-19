<?php
declare(strict_types=1);

namespace App\Services;

interface ReserveInterface
{
    public function getFreeTimeSlots(array $data);

    public function saveReserve(array $data);
}
