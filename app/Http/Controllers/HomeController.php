<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return response()->view('maintenance.home', [
            'title' => 'Fajar E-Maintenance'
        ]);
    }
}
