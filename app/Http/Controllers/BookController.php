<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class BookController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct(protected \BookInterface $bookService)
    {
    }

    public function showBookFormStep1()
    {
        return view("book.step1-form", ['users' => User::all()]);
    }

    public function showBookFormStep2(Request $request)
    {
        $data = $request->validate([
            "user_id" => ["required", "string"],
            "step_hour" => ["required", "integer", "min:1", "max:8"],
            "name" => ["required"],
            "phone" => ["required"],
        ]);

        try {
            $slotDto = $this->bookService->getFreeTimeSlots($data);
        } catch (\Exception $e) {
            return redirect(route("book_form_step1"))
                ->withErrors(
                    ["user_id" => $e->getMessage()]);
        }

        return view("book.step2-form", ['slotDto' => $slotDto]);
    }

    public function processBookForm(Request $request)
    {
        $timeSlot = json_decode($request->input('time_slot'), true);

        $this->bookService->saveTimeSlots(
            $request->input('user_id'),
            $request->input('name'),
            $request->input('phone'),
            $timeSlot,
        );

        return redirect(route('book_form_step1'))->with('message', 'Поздравляю, Вы записались!');
    }
}
