<?php

namespace App\Data;

class Modal
{
    public function __construct(public ?string $header = 'Message', public ?string $message = 'Message')
    {
    }
}
