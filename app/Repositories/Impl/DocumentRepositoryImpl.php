<?php

namespace App\Repositories\Impl;

use App\Models\Document;
use App\Repositories\DocumentRepository;
use App\Traits\Utility;

class DocumentRepositoryImpl implements DocumentRepository
{
    use Utility;

    public function insert(array $validated): bool
    {
        $document = new Document();
        $this->dataAssigment($document, $validated);
        $result = $document->save();
        return $result;
    }

    public function update(array $validated): void
    {
        $document = Document::query()->find($validated['id']);
        $this->dataAssigment($document, $validated);
        $document->update();
    }
}
