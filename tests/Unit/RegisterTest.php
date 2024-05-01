<?php

namespace Tests\Unit;

use App\Repositories\RegisterRepository;
use App\Services\MailSender;
use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
{

    public function testRegister(): void
    {

        $mockRegisterRepository = $this->createMock(RegisterRepository::class);
        $mockRegisterRepository->method('checkMail')->willReturnMap([
            ['example@test.com', false],
            ['ssseee795@gmail.com', true],
        ]);

        $mailSender = new MailSender($mockRegisterRepository);
        $message = $mailSender->sendMessage('example@test.com', 'some text');
        $this->assertFalse($message);

        $message = $mailSender->sendMessage('ssseee795@gmail.com', 'some text');
        $this->assertTrue($message);
    }
}
