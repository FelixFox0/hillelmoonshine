<?php

namespace App\Dto;

class ReserveDto implements ReserveDtoInterface
{
    private $userId;
    private $clientName;
    private $clientPhone;
    private $startTime;
    private $endTime;

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setClientName($clientName)
    {
        $this->clientName = $clientName;
    }

    public function setClientPhone($clientPhone)
    {
        $this->clientPhone = $clientPhone;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getClientName()
    {
        return $this->clientName;
    }

    public function getClientPhone()
    {
        return $this->clientPhone;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }
}
