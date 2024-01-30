<?php

namespace App\Repositories;

interface TrafoDetailRepository
{
    public function insert(array $validated): bool;

    public function update(array $validated): bool;
}
