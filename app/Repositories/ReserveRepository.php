<?php

namespace App\Repositories;

use App\Dto\ReserveDto;
use App\Models\Reserve;
use DateTime;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ReserveRepository
{

    public function save(ReserveDto $reserveDto)
    {
        // Встановлення 'start' на початок робочого часу
        $start = date('Y-m-d ') . config('reserve.workingStart');

        // Встановлення 'end' на кінець робочого часу
        $end = date('Y-m-d ') . config('reserve.workingEnd');

        return DB::table('reserves')->insertGetId([
            'user_id' => $reserveDto->getUserId(),
            'name' => $reserveDto->getName(),
            'phone' => $reserveDto->getPhone(),
            'start' => $start,
            'end' => $end,
        ]);
    }

    public function findById($reserveId)
    {
        $reserveData = DB::table('reserves')->where('id', $reserveId)->first();

        if ($reserveData) {
            return new ReserveDto(
                $reserveData->id,
                $reserveData->user_id,
                $reserveData->name,
                $reserveData->phone,
                $reserveData->start,
                $reserveData->end,
                null
            );
        }

        return null;
    }

    public function getReservesForUser($userId)
    {
        return DB::table('reserves')->where('user_id', $userId)->get();
    }

    public function update(ReserveDto $reserveDto)
    {
        $reserveId = $reserveDto->getId();
        $reserve = Reserve::find($reserveId);

        if (!$reserve) {
            return null;
        }

        // Перетворення часу в відповідний формат
        $startTime = date('Y-m-d H:i:s', strtotime($reserveDto->getStart()));
        $endTime = date('Y-m-d H:i:s', strtotime($reserveDto->getEnd()));

        // Оновлення даних резерву
        $reserve->start = $startTime;
        $reserve->end = $endTime;
        $reserve->save();

        return true;
    }
}
