<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ReserveInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReserveController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct(protected ReserveInterface $bookService)
    {
    }

    public function showSelectUserForm()
    {
        return view("book.select-user-form", ['users' => User::all()]);
    }

    public function showSelectTimeSlotForm(Request $request)
    {
        $data = $request->validate([
            "user_id" => ["required", "integer", Rule::exists(User::class, 'id')],
            "step_hour" => ["required", "integer", "min:1", "max:11"],
            "name" => ["required", "string", "max:50"],
            "phone" => ["required", "string", "max:15"],
        ]);

        try {
            $reserveDto = $this->bookService->getFreeTimeSlots($data);
        } catch (\Exception $e) {
            return redirect(route("select_user_from"))
                ->withErrors(
                    ["user_id" => $e->getMessage()]);
        }

        return view("book.select-time-form", ['reserveDto' => $reserveDto]);
    }

    public function processBookForm(Request $request)
    {
        $data = $request->validate([
            "user_id" => ["required", "integer", Rule::exists(User::class, 'id')],
            "time_slot" => ["required", "string"],
            "name" => ["required", "string", "max:50"],
            "phone" => ["required", "string", "max:15"],
        ]);

        $reserveDto = $this->bookService->saveReserve($data);

        return view("book.confirmation", ['reserveDto' => $reserveDto]);
    }
}
