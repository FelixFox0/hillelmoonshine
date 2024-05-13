<?php

namespace App\Http\Controllers;

use App\Repositories\ReserveRepository;

interface ReserveControllerInterface
{
    public function calculateAvialableIntervals(ReserveRepository $reservesRepository);

    public function addUserReserve(ReserveRepository $reservesRepository);
}
