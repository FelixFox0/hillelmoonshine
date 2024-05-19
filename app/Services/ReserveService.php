<?php

namespace App\Services;

use App\Dto\ReserveDto;
use App\Models\Reserve;
use App\Models\User;
use App\Repositories\ReserveRepository;
use Carbon\Carbon;
use Exception;

class ReserveService implements ReserveInterface
{
    public function __construct(protected ReserveRepository $reserveRepository) {}

    /**
     * @throws Exception
     */
    public function getFreeTimeSlots(array $data)
    {
        $stepHour = $data['step_hour'];
        $userId   = $data['user_id'];

        $workingStart = config('reserve.workingStart');
        $workingEnd = config('reserve.workingEnd');
        $stepMinute = $stepHour * 60;

        $startTime = Carbon::parse($workingStart);
        $endTime = Carbon::parse($workingEnd);

        $bookedSlots = $this->reserveRepository->getBookedTineSlots($userId);

        $timePeriods = [];
        for ($time = $startTime; $time->lessThan($endTime); $time->addMinutes($stepMinute)) {

            $start = $time->copy();
            $end  = $time->copy()->addMinutes($stepMinute) > $endTime ? $endTime : $time->copy()->addMinutes($stepMinute);

            if ($this->isBookedTime($bookedSlots, $start, $end)) {
                continue;
            }

            $timePeriods[] = [
                'start' => $start,
                'end' => $end,
            ];
        }

        if (empty($timePeriods)) {
            $user = User::where('id', $data['user_id'])->first();
            throw new Exception("У пользователя {$user->name} нет свободных слотов");
        }

        $reserveDto = new ReserveDto();
        $reserveDto->setUserId($data['user_id']);
        $reserveDto->setName($data['name']);
        $reserveDto->setPhone($data['phone']);
        $reserveDto->setSlots($timePeriods);

        return $reserveDto;
    }

    private function isBookedTime($bookedSlots, $start, $end): bool
    {
        /** @var Reserve $slot */
        foreach ($bookedSlots as $slot) {
            if ( $start >= Carbon::parse($slot->start) && $end <= Carbon::parse($slot->end)
             || $start < Carbon::parse($slot->start) && ($end > Carbon::parse($slot->start) && $end <= Carbon::parse($slot->end))
             || ($start >= Carbon::parse($slot->start) && $start < Carbon::parse($slot->end)) && $end > Carbon::parse($slot->end)) {
                return true;
            }
        }

        return false;
    }

    public function saveReserve(array $data): ReserveDto
    {
        $reserveDto = new ReserveDto();
        $reserveDto->setUserId($data['user_id']);
        $reserveDto->setName($data['name']);
        $reserveDto->setPhone($data['phone']);
        $reserveDto->setSlots(json_decode($data['time_slot'], true));

        return $this->reserveRepository->saveReserve($reserveDto);
    }
}
