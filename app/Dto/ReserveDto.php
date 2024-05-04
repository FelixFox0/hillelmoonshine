<?php

namespace App\Dto;

class ReserveDto
{
    private int $userId;
    private string $name;
    private string $phone;
    private array $slots;
    private int $reserveId;

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

    public function getReserveId(): int
    {
        return $this->reserveId;
    }

    public function setReserveId(int $reserveId): void
    {
        $this->reserveId = $reserveId;
    }
}
