<?php

namespace App\Repositories;

use App\Dto\ReserveDto;
use App\Models\Reserve;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReserveRepository
{

    public function getBookedTineSlots(int $userId)
    {
        return Reserve::where('user_id', $userId)->get();
    }
    public function saveReserve(ReserveDto $dto)
    {
        $reserve = Reserve::create([
            'user_id' => $dto->getUserId(),
            'name' => $dto->getName(),
            'phone' => $dto->getPhone(),
            'start' => Carbon::parse($dto->getSlots()['start'])->format('Y-m-d H:i:s'),
            'end' => Carbon::parse($dto->getSlots()['end'])->format('Y-m-d H:i:s'),
        ]);

        $dto->setReserveId($reserve->id);

        return $dto;
    }
}
