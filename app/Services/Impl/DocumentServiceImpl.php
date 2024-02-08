<?php

namespace App\Services\Impl;

use App\Models\Document;
use App\Repositories\DocumentRepository;
use App\Services\DocumentService;
use App\Traits\Utility;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentServiceImpl implements DocumentService
{
    use Utility;

    private DocumentRepository $documentRepository;

    public function __construct(DocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    public function getAll(): Collection
    {
        $documents = DB::table('documents')->orderBy('created_at', 'desc')->get();
        return $documents;
    }

    public function insert(array $validated): bool
    {
        return $this->documentRepository->insert($validated);
    }

    public function saveAttachment(UploadedFile $attachment, string $attachment_name): void
    {
        $attachment->storePubliclyAs('documents', $attachment_name . '.' . strtolower($attachment->getClientOriginalExtension()), 'public');
    }

    public function insertWithAttachment(UploadedFile $attachment, array $validated): void
    {
        $this->insert($validated);
        $this->saveAttachment($attachment, $validated['id']);
    }

    public function update(array $validated): void
    {
        $this->documentRepository->update($validated);
    }

    public function updateWithAttachment(UploadedFile $attachment, array $validated): void
    {
        $id = $validated['id'];
        $existing_document = Document::query()->find($id);

        if (!is_null($existing_document->attachment)) {
            Storage::disk('public')->delete("documents/$existing_document->attachment");
        }

        $this->update($validated);
        $this->saveAttachment($attachment, $id);
    }
}
