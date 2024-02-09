<?php

namespace Tests\Feature;

use App\Services\DocumentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DocumentServiceTest extends TestCase
{
    public function testDocumentService()
    {
        $documentService = $this->app->make(DocumentService::class);
        self::assertNotNull($documentService);
    }
}
