<?php

namespace App\Http\Controllers;

use App\Repositories\ReserveRepositoryInterface;
use Illuminate\Support\Facades\Config;

class ReserveController implements ReserveControllerInterface
{
    public function calculateAvialableIntervals(ReserveRepositoryInterface $reservesRepository)
    {
        $userId = $_POST['user_id'];
        $reservePeriod = $_POST['reserve_period'];
        $clientName = $_POST['client_name'];
        $clientPhone = $_POST['client_phone'];

        $workingStart = Config::get('reserve.workingStart');
        $workingEnd = Config::get('reserve.workingEnd');

        $workingStartHours = date('H', strtotime($workingStart));
        $workingEndHours = date('H', strtotime($workingEnd));

        // Формуємо список всіх можливих інтервалів, враховуючи початок та кінець робочого часу
        $availableIntervals = [];
        for ($hours = $workingStartHours; $hours <= $workingEndHours - $reservePeriod; $hours += 1) {
            $availableIntervals[] = [
                'start_time' => date('H', $hours * 60 * 60),
                'end_time' => date('H', ($hours + $reservePeriod) * 60 * 60),
            ];
        }

        // Отримуємо з БД список зайнятих інтервалів для заданого користувача
        $busyIntervals = [];
        $data = $reservesRepository->getAllReservesByUserId($userId);
        foreach ($data as $reservePeriod) {
            $busyIntervals[] = [
                'start_time' => date('H', strtotime($reservePeriod->start_time)),
                'end_time' => date('H', strtotime($reservePeriod->end_time)),
            ];
        }

        // Матчимо та отримуємо список доступних для бронювання інтервалів
        foreach ($availableIntervals as $avialableKey => $avialableInterval) {
            foreach ($busyIntervals as $busyInterval) {
                if (
                    ($avialableInterval['start_time'] >= $busyInterval['start_time'] &&
                        $avialableInterval['start_time'] < $busyInterval['end_time']) ||
                    ($avialableInterval['end_time'] > $busyInterval['start_time'] &&
                        $avialableInterval['end_time'] <= $busyInterval['end_time']) ||
                    ($busyInterval['start_time'] >= $avialableInterval['start_time'] &&
                        $busyInterval['start_time'] < $avialableInterval['end_time']) ||
                    ($busyInterval['end_time'] > $avialableInterval['start_time'] &&
                        $busyInterval['end_time'] <= $avialableInterval['end_time'])
                ) {
                    unset($availableIntervals[$avialableKey]);
                }
            }
        }

        if (count($availableIntervals) === 0) {
            return view('unavailable');
        }

        return view('interval', [
            'userId' => $userId,
            'clientName' => $clientName,
            'clientPhone' => $clientPhone,
            'availableIntervals' => $availableIntervals,
        ]);
    }

    public function addUserReserve(ReserveRepositoryInterface $reservesRepository)
    {
        $userId = $_POST['user_id'];
        $clientName = $_POST['client_name'];
        $clientPhone = $_POST['client_phone'];

        $startTime = explode('-', $_POST['interval'])[0];
        $endTime = explode('-', $_POST['interval'])[1];
        $startDateTime = date('Y-m-d', strtotime('now')) . ' ' . $startTime;
        $endDateTime = date('Y-m-d', strtotime('now')) . ' ' . $endTime;

        $reservesRepository->addUserReserve($userId, $clientName, $clientPhone, $startDateTime, $endDateTime);
        return view('success');
    }
}
