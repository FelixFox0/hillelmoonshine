<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\ReservationRepository;
use Illuminate\Support\Facades\Config;
use DateTime;
use App\Helpers\helpers;

class ReservationController extends Controller
{
    protected $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function create()
    {
        $users = User::all();
        return view('create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required',
            'phone' => 'required',
            'hours' => 'required|integer|min:1',
        ]);

        $userId = $request->input('user_id');
        $startTime = new DateTime($request->input('reserved_at'));

        if (!$this->reservationRepository->isAvailableForUser($userId, $startTime)) {
            return back()->with('error', 'Час уже зайнятий. Виберіть інше.');
        }

        $hours = $request->input('hours');

        $availableHours = $this->reservationRepository->getAvailableHours($hours, $userId);

        return view('confirm', compact('request', 'availableHours'));
    }


    public function confirm(Request $request)
    {
        $request->validate([
            'reserved_at' => 'required',
        ]);

        $reservedAtParts = explode(' - ', $request->reserved_at);
        $startTime = new DateTime($reservedAtParts[0]);
        $endTime = new DateTime($reservedAtParts[1]);

        $userId = $request->input('user_id');

        if (!$this->reservationRepository->isAvailableForUser($userId, $startTime)) {
            return back()->with('error', 'Час уже зайнятий. Виберіть інше.');
        }

        $isAvailable = $this->reservationRepository->isAvailable(
            $request->user_id,
            $startTime,
            $endTime
        );

        if (!$isAvailable) {
            return back()->with('error', 'Час уже зайнятий. Виберіть інше.');
        }

        $reservation = $this->reservationRepository->create([
            'user_id' => $request->user_id,
            'hours' => $request->input('hours'),
            'name' => $request->name,
            'phone' => $request->phone,
            'start' => $startTime,
            'end' => $endTime,
        ]);

        if ($reservation) {
            return redirect()->route('success')->with('success', 'Успішно зарезервовано');
        } else {
            return back()->with('error', 'Помилка резервування');
        }
    }
}