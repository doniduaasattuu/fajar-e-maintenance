<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface DocumentService
{
    public function getAll(): Collection;

    public function insert(array $validated): bool;

    public function saveAttachment(UploadedFile $attachment, string $attachment_name): void;

    public function insertWithAttachment(UploadedFile $attachment, array $validated): void;

    public function update(array $validated): void;

    public function updateWithAttachment(UploadedFile $attachment, array $validated): void;
}
