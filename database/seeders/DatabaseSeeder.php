<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\EmoRecord;
use App\Models\EmoDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('transformer_records')->delete();
        DB::table('transformer_details')->delete();
        DB::table('transformers')->delete();
        DB::table('emo_records')->delete();
        DB::table('emo_details')->delete();
        DB::table('emos')->delete();
        DB::table('function_locations')->delete();
        DB::table('administrators')->delete();
        DB::table('users')->delete();

        $this->call([
            UserSeeder::class,
            AdministratorsSeeder::class,
            FunctionLocationSeeder::class,
            EmoSeeder::class,
            EmoDetailSeeder::class,
            EmoRecordSeeder::class,
            TransformersSeeder::class,
            TransformerDetailSeeder::class,
            TransformerRecordSeeder::class,
        ]);
    }
}
