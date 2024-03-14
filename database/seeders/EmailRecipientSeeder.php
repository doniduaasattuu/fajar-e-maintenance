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
        $users = User::get();

        for ($i = 0; $i < 4; $i++) {
            EmailRecipient::create([
                'email' => $users[$i]->email_address,
                'name' => $users[$i]->fullname,
            ]);
        }
    }
}
