<?php

namespace Tests\Feature;

use App\Models\Document;
use Database\Seeders\DocumentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    public function testDocumentSeeder()
    {
        $this->seed(DocumentSeeder::class);

        $documents = Document::query()->get();
        self::assertNotNull($documents);
        self::assertCount(5, $documents);
    }
}
