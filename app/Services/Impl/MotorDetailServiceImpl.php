<?php

namespace App\Services\Impl;

use App\Repositories\MotorDetailRepository;
use App\Services\MotorDetailService;

class MotorDetailServiceImpl implements MotorDetailService
{
    private MotorDetailRepository $motorDetailRepository;

    public function __construct(MotorDetailRepository $motorDetailRepository)
    {
        $this->motorDetailRepository = $motorDetailRepository;
    }

    public function register(array $validated): bool
    {
        return $this->motorDetailRepository->insert($validated);
    }

    public function updateMotorDetail(array $validated): bool
    {
        return $this->motorDetailRepository->update($validated);
    }
}
