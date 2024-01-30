<?php

namespace App\Repositories;

interface TrafoRepository
{
    public function insert(array $validated): bool;

    public function update(array $validated): bool;
}
