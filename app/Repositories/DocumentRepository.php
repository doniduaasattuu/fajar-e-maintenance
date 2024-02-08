<?php

namespace App\Repositories;

interface DocumentRepository
{
    public function insert(array $validated): bool;

    public function update(array $validated): void;
}
