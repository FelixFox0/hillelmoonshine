<?php

namespace App\Repositories;

use App\Models\Reservation;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ReservationRepository
{
    public function getAvailableHours($hours, $userId)
    {
        $workingStart = Config::get('reserve.workingStart');
        $workingEnd = Config::get('reserve.workingEnd');
        $stepMinute = Config::get('reserve.stepMinute');

        $existingReservations = Reservation::where('user_id', $userId)
            ->get();

        $availableHours = [];
        $currentTime = strtotime($workingStart);
        $workingEndTimestamp = strtotime($workingEnd);

        while ($currentTime <= $workingEndTimestamp) {
            $endHour = strtotime("+{$hours} hours", $currentTime);
            if ($endHour <= $workingEndTimestamp) {
                $isAvailable = true;
                foreach ($existingReservations as $reservation) {
                    $start = strtotime($reservation->start);
                    $end = strtotime($reservation->end);
                    if (($currentTime >= $start && $currentTime < $end) || ($endHour > $start && $endHour <= $end)) {
                        $isAvailable = false;
                        break;
                    }
                }
                if ($isAvailable) {
                    $availableHours[] = date('H:i', $currentTime) . ' - ' . date('H:i', $endHour);
                }
            }
            $currentTime += $stepMinute * 60;
        }

        return $availableHours;
    }



    public function create($data)
    {
        $reservation = new Reservation;
        $reservation->user_id = $data['user_id'];
        $reservation->hours = $data['hours'];
        $reservation->name = $data['name'];
        $reservation->phone = $data['phone'];
        $reservation->start = $data['start'];
        $reservation->end = $data['end'];
        $reservation->save();

        return $reservation;
    }


    public function isAvailable($userId, $startTime, $endTime)
    {
        $existingReservation = Reservation::where('user_id', $userId)
            ->where('start', '<=', $endTime)
            ->where('end', '>=', $startTime)
            ->first();

        return !$existingReservation;
    }

    public function isAvailableForUser($userId, $startTime)
    {
        $existingReservation = Reservation::where('user_id', $userId)
            ->where('start', '<=', $startTime)
            ->where('end', '>=', $startTime)
            ->first();

        return !$existingReservation;
    }
}
