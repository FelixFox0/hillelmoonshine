<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginPage(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testSendLoginFormFail(): void
    {
        $response = $this->post('login_process', [
            'email' => 'excample@test.com',
            'password' => 'qwerty',
        ]);

        $response->assertStatus(302);
    }

    public function testSendLoginForm(): void
    {

        $user = User::factory()->create([
            'email' => 'example@test.com',
            'password' => 'qwerty',
        ]);

        $response = $this->post('login_process', [
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }
}
