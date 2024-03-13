<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendWelcomeEmail()
    {
        $title = 'Welcome to Fajar E-Maintenance';
        $body = 'Thank you for providing web hosting';

        Mail::to('elc357@fajarpaper.com')->send(new WelcomeMail($title, $body));

        return 'Email sent successfully!';
    }
}
