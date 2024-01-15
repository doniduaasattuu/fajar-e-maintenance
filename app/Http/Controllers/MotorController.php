<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Services\MotorService;
use Illuminate\Http\Request;

class MotorController extends Controller
{
    private MotorService $motorService;

    public function __construct(MotorService $motorService)
    {
        $this->motorService = $motorService;
    }

    public function motors()
    {
        return response()->view('maintenance.motor.motor', [
            'title' => 'Table motor',
            'motorService' => $this->motorService,
        ]);
    }
}
