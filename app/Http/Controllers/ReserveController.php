<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use App\Reserve\ReserveService;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\ReserveRepository;
use App\Dto\ReserveDto;
use Illuminate\Support\Facades\Redirect;


class ReserveController extends Controller
{
    protected $userRepository;
    protected $reserveRepository;
    private $reserveService;

    public function __construct(UserRepository $userRepository, ReserveRepository $reserveRepository, ReserveService $reserveService)
    {
        $this->userRepository = $userRepository;
        $this->reserveRepository = $reserveRepository;
        $this->reserveService = $reserveService;
    }

    public function showCreateReserveForm()
    {
        $users = $this->userRepository->all();
        return view('reserve.create', compact('users'));
    }

    public function createReserve(Request $request)
    {
        $validatedData = $this->reserveService->validateReserveData($request->all());

        // Отримання доступних часових слотів з сервісу
        $userId = $validatedData['user_id'];
        $hours = $validatedData['hours'];
        $availableTimes = $this->reserveService->getAvailableTimes($userId, $hours);

        // Перевірка чи доступні часові слоти
        if (empty($availableTimes)) {
            return Redirect::route('reservation.no-times')->withErrors(['no_slots' => 'Немає доступних слотів.']);
        }

        // Збереження резерву і отримання його ідентифікатора
        $reserveId = $this->reserveService->processReserve($validatedData);

        // Передача даних про доступні часові слоти, кількість заброньованих годин та ідентифікатора резерву на сторінку вибору часу
        return view('reserve.select-time', compact('availableTimes', 'validatedData', 'reserveId'));
    }

    public function showConfirmationForm($reserveId)
    {
        // Отримання резерву за його ID
        $reserve = $this->reserveRepository->findById($reserveId);

        if (!$reserve) {
            return view('reserve.no-reserve');
        }

        // Передача даних про резерв на сторінку підтвердження
        return view('reserve.confirmation', compact('reserve'));
    }

    public function confirmReserve(Request $request, $reserveId)
    {
        $requestData = $request->validate([
            'time' => 'required',
        ]);

        // Розділення рядку на початковий та кінцевий час
        $timeRange = explode(' - ', $requestData['time']);

        // Отримання резерву з бази даних за його ID
        $reserve = $this->reserveRepository->findById($reserveId);

        if (!$reserve) {
            return view('reserve.no-reserve');
        }

        // Встановення значення 'start' та 'end'
        $reserve->setStart($timeRange[0]);
        $reserve->setEnd($timeRange[1]);

        // Збереження оновлених даних в базі даних
        $this->reserveRepository->update($reserve);

        // Перенаправлення на сторінку підтвердження
        return redirect()->route('reservation.confirmation.submit', ['reserveId' => $reserveId]);
    }
}

