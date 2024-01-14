<?php

namespace App\Services\Impl;

use App\Models\Funcloc;
use App\Repositories\FunclocRepository;
use App\Services\FunclocService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FunclocServiceImpl implements FunclocService
{
    private FunclocRepository $funclocRepository;

    public function __construct(FunclocRepository $funclocRepository)
    {
        $this->funclocRepository = $funclocRepository;
    }

    public function getAll(): Collection
    {
        $funclocs = Funcloc::query()->get();
        return $funclocs;
    }

    public function getTableColumns(): array
    {
        $tableColumns = $this->funclocRepository->tableColumns;
        return $tableColumns;
    }

    public function registeredFunclocs(): array
    {
        $funclocs_id = Funcloc::query()->pluck('id');
        return $funclocs_id->toArray();
    }

    public function register(array $validated): bool
    {
        return $this->funclocRepository->insert($validated);
    }

    public function updateFuncloc(array $validated): bool
    {
        return $this->funclocRepository->update($validated);
    }
}
