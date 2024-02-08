<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = new Filesystem();
        $files->cleanDirectory('storage/app/public/documents');

        for ($i = 0; $i < 5; $i++) {

            $id = uniqid();
            $extension = 'pdf';
            $attachment = UploadedFile::fake()->create($id, 500, $extension);
            $attachment->storePubliclyAs('documents', $attachment->getClientOriginalName() . '.' . $extension, 'public');

            $document = new Document();
            $document->id = $id;
            $document->title = 'Wiring - ' . $i;
            $document->attachment = $id . '.' . $extension;
            $document->area = array(0 => 'PM3', 1 => 'SP3', 2 => 'PM7', 3 => 'SP7', 4 => 'PM5', 5 => 'SP5', 6 => 'PM8', 7 => 'SP8', 8 => 'PM2', 9 => 'SP2', 10 => 'PM1', 11 => 'SP1')[rand(0, 11)];
            $document->equipment = null;
            $document->funcloc = null;
            $document->save();
        }
    }
}
