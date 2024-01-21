<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function home()
    {
        return response()->view('maintenance.home', [
            'title' => 'Fajar E-Maintenance',
            'userService' => $this->userService,
        ]);
    }
}
