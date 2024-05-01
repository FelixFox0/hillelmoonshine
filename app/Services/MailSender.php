<?php

namespace App\Services;

use App\Repositories\RegisterRepository;

class MailSender
{
    protected $registerRepository;
    public function __construct(RegisterRepository $registerRepository)
    {
        $this->registerRepository = $registerRepository;
    }

    public function sendMessage(string $mail, string $text): bool
    {

        if ($this->registerRepository->checkMail($mail)) {
            // send message
            return true;
        }

        return false;
    }

}
