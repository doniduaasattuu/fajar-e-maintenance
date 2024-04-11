<?php

namespace Database\Seeders;

use App\Models\PubShare;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PubShareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $id = uniqid();

        $pub_share = new PubShare();
        $pub_share->id = $id;
        $pub_share->title = 'Contoh file';
        $pub_share->nik = '55000154';
        $pub_share->attachment = "$id.jpg";
        $pub_share->save();
    }
}
