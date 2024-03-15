<?php

namespace Database\Seeders;

use App\Models\EmailRecipient;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailRecipientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailRecipient::insert([
            [
                'email' => User::findOrFail('55000154')->email_address,
                'name' => User::findOrFail('55000154')->fullname,
            ],
            [
                'email' => User::findOrFail('31100019')->email_address,
                'name' => User::findOrFail('31100019')->fullname,
            ],
            [
                'email' => User::findOrFail('31100156')->email_address,
                'name' => User::findOrFail('31100156')->fullname,
            ],
            [
                'email' => User::findOrFail('31811016')->email_address,
                'name' => User::findOrFail('31811016')->fullname,
            ],
        ]);
    }
}
