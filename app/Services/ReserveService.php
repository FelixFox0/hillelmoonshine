<?php

namespace App\Services;

use App\Dto\ReserveDto;
use App\Models\Reserve;
use App\Repositories\ReserveRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;


class ReserveService
{
    protected $userRepository;
    protected $reserveRepository;

    public function __construct(UserRepository $userRepository, ReserveRepository $reserveRepository)
    {
        $this->userRepository = $userRepository;
        $this->reserveRepository = $reserveRepository;
    }

    public function getAvailableTimes(int $userId, int $hours)
    {
        $reserves = $this->reserveRepository->getReservesForUser($userId);
        $workingStart = strtotime(config('reserve.workingStart'));
        $workingEnd = strtotime(config('reserve.workingEnd')) - $hours * 60 * 60;
        $stepMinute = config('reserve.stepMinute');

        $times = [];

        for ($time = $workingStart; $time <= $workingEnd; $time += $stepMinute * 60) {
            $end = $time + $hours * 60 * 60;

            if (!$this->isTimeReserved($reserves, $time, $end)) {
                $times[] = date('H:i', $time) . ' - ' . date('H:i', $end);
            }
        }

        return $times;
    }

    protected function isTimeReserved($reserves, $start, $end)
    {
        foreach ($reserves as $reserve) {
            if ($start < strtotime($reserve->end) && $end > strtotime($reserve->start)) {
                return true;
            }
        }

        return false;
    }

    public function processReserve($requestData)
    {
        $validatedData = $this->validateReserveData($requestData);

        $user = $this->userRepository->findById($validatedData['user_id']);

        // Логіка для визначення доступних опцій бронювання на основі конфігурації
        $availableOptions = $this->getAvailableTimes($validatedData['user_id'], $validatedData['hours']);

        $reserveDto = new ReserveDto(
            null,
            $user->getId(),
            $user->getName(),
            $validatedData['phone'],
            $availableOptions,
            $availableOptions,
            $validatedData['hours'],
        );

        return $this->reserveRepository->save($reserveDto);
    }

    public function validateReserveData($data)
    {
        return validator($data, [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|max:50',
            'phone' => 'required|string|max:15',
            'hours' => 'required|integer|between:1,11',
        ])->validate();
    }
}


