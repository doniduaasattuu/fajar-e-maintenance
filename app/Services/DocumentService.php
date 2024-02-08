<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface DocumentService
{
    public function getAll(): Collection;
}
