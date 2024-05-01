<?php

namespace App\Http\Controllers;

//use App\Jobs\ForgotUserEmailJob;
//use App\Mail\ForgotPassword;
use App\Models\User;
//use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Mail;
use App\Services\MailSender;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view("auth.login");
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            "email" => ["required", "email", "string"],
            "password" => ["required"]
        ]);

        if(auth("web")->attempt($data)) {
            return redirect(route("home"));
        }

        return redirect(route("login"))
            ->withErrors(
                ["email" => "Користувача не знайдено, або данні ввені не вірно"]);
    }

    public function logout()
    {
        auth("web")->logout();

        return redirect(route("home"));
    }

    public function showRegisterForm()
    {
        return view("auth.register");
    }

    public function showForgotForm()
    {
        return view("auth.forgot");
    }

    public function forgot(Request $request)
    {
        $data = $request->validate([
            "email" => ["required", "email", "string"],
        ]);

        $user = User::where(["email" => $data["email"]])->first();

        $password = uniqid();

        $user->password = bcrypt($password);
        $user->save();

//        тут повинна бути відправка форми

        return redirect(route("home"));
    }

    public function register(Request $request, MailSender $mailSender)
    {
        $data = $request->validate([
            "name" => ["required", "string"],
            "email" => ["required", "email", "string", "unique:users,email"],
            "password" => ["required", "confirmed"]
        ]);

        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => bcrypt($data["password"])
        ]);

//        тут може бути викликана відправка повідомння на email для сповіщення або, для підтвердження
        $mailSender->sendMessage($data["email"], 'success');

        if($user) {
            auth("web")->login($user);
        }

        return redirect(route("home"));
    }
}
