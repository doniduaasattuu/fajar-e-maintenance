<?php

namespace App\Repositories;

interface FindingRepository
{
    public function insert(array $validated): bool;
}
