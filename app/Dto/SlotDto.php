<?php

namespace App\Dto;

class SlotDto
{
    private int $userId;
    private string $name;
    private string $phone;

    private array $slots;

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getSlots(): array
    {
        return $this->slots;
    }

    public function setSlots(array $slots): void
    {
        $this->slots = $slots;
    }
}
