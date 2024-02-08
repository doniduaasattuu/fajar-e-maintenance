<?php

namespace App\Services\Impl;

use App\Models\Document;
use App\Services\DocumentService;
use App\Traits\Utility;
use Illuminate\Support\Collection;

class DocumentServiceImpl implements DocumentService
{
    use Utility;

    public function getAll(): Collection
    {
        $documents = Document::query()->get();
        return $documents;
    }
}
