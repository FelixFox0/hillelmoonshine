<?php

namespace App\Dto;

class ReserveDto
{
    private $id;
    private $userId;
    private $name;
    private $phone;
    private $start;
    private $end;
    private $hours;

    public function __construct($id, int $userId, $name, $phone, $start, $end, $hours)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->phone = $phone;
        $this->start = $start;
        $this->end = $end;
        $this->hours = $hours;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function getHours()
    {
        return $this->hours;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function setEnd($end)
    {
        $this->end = $end;
    }
}
