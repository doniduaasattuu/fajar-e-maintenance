<?php

namespace App\Repositories;

interface FunclocRepository
{
    public function insert(array $validated): bool;

    public function update(array $validated): bool;
}
