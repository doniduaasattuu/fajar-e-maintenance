<?php

namespace App\Services;

interface TrafoDetailService
{
    public function register(array $validated): bool;

    public function updateTrafoDetail(array $validated): bool;
}
