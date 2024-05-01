<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testLogout(): void
    {
        $user = User::factory()->create([
            'email' => 'example@test.com',
            'password' => 'qwerty',
        ]);

        $response = $this->actingAs($user, 'web');
        $this->assertTrue(Auth::check());
        $response->get('/logout');
        $this->assertFalse(Auth::check());
    }
}
