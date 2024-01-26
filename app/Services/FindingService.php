<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

interface FindingService
{
    public function insert(array $validated): bool;

    public function saveImage(UploadedFile $image, string $image_url): void;
}
