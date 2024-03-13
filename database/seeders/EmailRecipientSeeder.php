<?php

namespace Database\Seeders;

use App\Models\EmailRecipient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailRecipientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            EmailRecipient::create([
                'email' => fake('id_ID')->email()
            ]);
        }
    }
}
