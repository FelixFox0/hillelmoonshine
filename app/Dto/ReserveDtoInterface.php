<?php

namespace App\Dto;

interface ReserveDtoInterface
{
    public function setUserId($userId);

    public function setClientName($clientName);

    public function setClientPhone($clientPhone);

    public function setStartTime($startTime);

    public function setEndTime($endTime);

    public function getUserId();

    public function getClientName();

    public function getClientPhone();

    public function getStartTime();

    public function getEndTime();
}
