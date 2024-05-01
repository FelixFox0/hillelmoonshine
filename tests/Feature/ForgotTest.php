<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class ForgotTest extends TestCase
{
    use RefreshDatabase;

    public function testForgot(): void
    {
        $client_mock = Mockery::mock('overload:App\Models\User');
        $client_mock->email = 'example@test.com';
        $client_mock->shouldReceive('where')->with(["email" => 'example@test.com'])->andReturn($client_mock);
        $client_mock->shouldReceive('first')->andReturn($client_mock);
        $client_mock->shouldReceive('save')->andReturn(true);

        $response = $this->post('/forgot_process', ["email" => 'example@test.com']);

        $response->assertStatus(302);
    }

}
