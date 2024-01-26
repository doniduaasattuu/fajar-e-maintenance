<?php

namespace App\Services\Impl;

use App\Models\Finding;
use App\Repositories\FindingRepository;
use App\Services\FindingService;
use Illuminate\Http\UploadedFile;

class FindingServiceImpl implements FindingService
{
    private FindingRepository $findingRepository;

    public function __construct(FindingRepository $findingRepository)
    {
        $this->findingRepository = $findingRepository;
    }

    public function insert(array $validated): bool
    {
        return $this->findingRepository->insert($validated);
    }

    public function saveImage(UploadedFile $image, string $image_url): void
    {
        $image->storePubliclyAs('findings', $image->getClientOriginalName(), 'public');
    }
}
