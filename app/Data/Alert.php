<?php

namespace App\Data;

class Alert
{

    public string $message;
    public string $variant;

    public function __construct(string $message, string $variant)
    {
        $this->message = $message;
        $this->variant = $variant;
    }
}
