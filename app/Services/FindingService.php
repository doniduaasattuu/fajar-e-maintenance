<?php

namespace App\Services;

use App\Models\Finding;
use Illuminate\Http\UploadedFile;

interface FindingService
{
    public function insert(array $validated): bool;

    public function saveImage(UploadedFile $image, string $image_name): void;

    public function insertWithImage(UploadedFile $image, array $validated): void;

    public function update(array $validated): void;

    public function updateWithImage(UploadedFile $image, array $validated): void;

    public function deleteImage(Finding $finding): void;
}
