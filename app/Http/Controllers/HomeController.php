<?php

namespace App\Http\Controllers;

use App\Services\MotorService;
use App\Services\UserService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private UserService $userService;
    private MotorService $motorService;

    public function __construct(UserService $userService, MotorService $motorService)
    {
        $this->userService = $userService;
        $this->motorService = $motorService;
    }

    public function home()
    {
        return response()->view('maintenance.home', [
            'title' => 'Fajar E-Maintenance',
            'userService' => $this->userService,
        ]);
    }

    public function scanner()
    {
        return response()->view('maintenance.scanner', [
            'title' => 'Scanner'
        ]);
    }

    public function checkingForm()
    {
        return response()->view('maintenance.motor.checking-form', [
            'title' => 'Checking form',
            'motorService' => $this->motorService,
        ]);
    }
}
