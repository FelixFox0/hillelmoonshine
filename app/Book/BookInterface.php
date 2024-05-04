<?php

interface BookInterface
{
    public function getFreeTimeSlots(array $data);

    public function saveTimeSlots(int $userId, string $name, string $phone, array $slot);
}
