<?php

namespace App\Data;

class Alert
{
    public function __construct(public string $message, public ?string $variant = 'alert-danger', public ?string $link = null)
    {
    }
}
