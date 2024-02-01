<?php

namespace App\Repositories;

interface TrafoRecordRepository
{
    public function insert(array $validated): bool;
}
