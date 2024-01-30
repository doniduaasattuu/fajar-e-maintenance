<?php

namespace App\Services\Impl;

use App\Repositories\TrafoDetailRepository;
use App\Services\TrafoDetailService;

class TrafoDetailServiceImpl implements TrafoDetailService
{
    private TrafoDetailRepository $trafoDetailRepository;

    public function __construct(TrafoDetailRepository $trafoDetailRepository)
    {
        $this->trafoDetailRepository = $trafoDetailRepository;
    }

    public function register(array $validated): bool
    {
        return $this->trafoDetailRepository->insert($validated);
    }

    public function updateTrafoDetail(array $validated): bool
    {
        return $this->trafoDetailRepository->update($validated);
    }
}
