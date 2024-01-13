<?php

namespace Database\Seeders;

use App\Models\Funcloc;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FunclocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::delete('delete from funclocs');

        $funloc = new Funcloc();
        $funloc->id = "FP-01-SP3-RJS-T092-P092";
        $funloc->tag_name = "Pompa P-70";
        $funloc->created_at = Carbon::now()->toDateTimeString();
        $funloc->updated_at = Carbon::now()->toDateTimeString();
        $funloc->save();
    }
}
