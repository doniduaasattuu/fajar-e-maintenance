<?php

namespace App\Services\Impl;

use App\Models\Finding;
use App\Repositories\FindingRepository;
use App\Services\FindingService;
use App\Traits\Utility;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FindingServiceImpl implements FindingService
{
    use Utility;
    private FindingRepository $findingRepository;
    public array $findingStatusEnum = ['Open', 'Closed'];

    public function __construct(FindingRepository $findingRepository)
    {
        $this->findingRepository = $findingRepository;
    }

    public function getAll(): Collection
    {
        $findings = Finding::query()->get();
        return $findings;
    }

    public function insert(array $validated): bool
    {
        return $this->findingRepository->insert($validated);
    }

    public function saveImage(UploadedFile $image, string $image_name): void
    {
        $image->storePubliclyAs('findings', $image_name . '.' . $image->getClientOriginalExtension(), 'public');
    }

    public function insertWithImage(UploadedFile $image, array $validated): void
    {
        $this->insert($validated);
        $this->saveImage($image, $validated['id']);
    }

    public function update(array $validated): void
    {
        $this->findingRepository->update($validated);
    }

    public function updateWithImage(UploadedFile $image, array $validated): void
    {
        $id = $validated['id'];
        $existing_finding = Finding::query()->find($id);
        Storage::disk('public')->delete("/findings/" . $existing_finding->image);

        $this->update($validated);
        $this->saveImage($image, $id);
    }

    public function deleteImage($finding): void
    {
        Storage::disk('public')->delete("/findings/" . $finding->image);
    }
}
