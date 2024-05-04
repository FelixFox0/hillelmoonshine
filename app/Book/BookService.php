<?php

namespace App\Book;

use App\Dto\SlotDto;
use App\Models\Reserve;
use App\Models\User;
use BookInterface;

class BookService implements BookInterface
{
    public function __construct(protected SlotDto $slotDto) {}

    /**
     * @throws \Exception
     */
    public function getFreeTimeSlots(array $data)
    {
        $stepHour = $data['step_hour'];
        $userId   = $data['user_id'];

        $workingStart = config('reserve.workingStart');
        $workingEnd = config('reserve.workingEnd');
        $stepMinute = $stepHour * 60;

        $startTime = \Carbon\Carbon::parse($workingStart);
        $endTime = \Carbon\Carbon::parse($workingEnd);

        $bookedSlots = Reserve::where('user_id', $userId)->get()->toArray();

        $timePeriods = [];
        for ($time = $startTime; $time->lessThan($endTime); $time->addMinutes($stepMinute)) {

            foreach ($bookedSlots as $bSlot) {

                $start = $time->copy();
                $end = $time->copy()->addMinutes($stepMinute);

                if ($bSlot['start'] == $start) {
                    continue;
                }

                $timePeriods[] = [
                    'start' => $start,
                    'end' => $end,
                ];
            }
        }

        if (empty($timePeriods)) {
            $user = User::where('id', $data['user_id'])->first();
            throw new \Exception("У пользователя {$user->name} нет свободных слотов");
        }

        $this->slotDto->setUserId($data['user_id']);
        $this->slotDto->setName($data['name']);
        $this->slotDto->setPhone($data['phone']);
        $this->slotDto->setSlots($timePeriods);

        return $this->slotDto;
    }

    public function saveTimeSlots(int $userId, string $name, string $phone, array $slot)
    {
        Reserve::create([
            'user_id' => $userId,
            'name' => $name,
            'phone' => $phone,
            'start' => \Carbon\Carbon::parse($slot['start'])->format('Y-m-d H:i:s'),
            'end' => \Carbon\Carbon::parse($slot['end'])->format('Y-m-d H:i:s'),
        ]);
    }
}
