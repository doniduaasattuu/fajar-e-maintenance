<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\User;
use App\Traits\Utility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class DocumentSeeder extends Seeder
{
    use Utility;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = new Filesystem();
        $files->cleanDirectory('storage/app/public/documents');
        $paper_machines = $this->areas();
        shuffle($paper_machines);
        $users = User::query()->get();

        for ($i = 0; $i < sizeof($paper_machines); $i++) {

            $id = uniqid();
            $extension = $i == 2 ? 'xlsx' : 'pdf';
            $attachment = UploadedFile::fake()->create($id, 500, $extension);
            $attachment->storePubliclyAs('documents', $attachment->getClientOriginalName() . '.' . $extension, 'public');

            $pm = $paper_machines[rand(0, sizeof($paper_machines) - 1)];
            $titles = array(0 => 'Schematic diagram panel incoming MDP 3kV', 1 => 'Schematic diagram panel incoming MDP 20kV', 2 => 'Schematic diagram panel outgoing MDP 3kV', 3 => 'Schematic diagram panel outgoing MDP 20kV');

            $document = new Document();
            $document->id = $id;
            $document->title =  $titles[rand(0, sizeof($titles) - 1)] . ' ' . $pm;
            $document->area = $pm;
            $document->department = Arr::random(["EI1", "EI2", "EI3", "EI4", "EI5", "EI6", "EI7"]);
            $document->equipment = null;
            $document->funcloc = null;
            $document->uploaded_by = $users[rand(0, count($users) - 1)]->abbreviated_name;
            $document->attachment = $id . '.' . $extension;
            $document->save();
        }
    }
}
