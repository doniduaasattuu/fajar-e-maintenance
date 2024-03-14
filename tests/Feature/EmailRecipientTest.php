<?php

namespace Tests\Feature;

use App\Models\EmailRecipient;
use Database\Seeders\EmailRecipientSeeder;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailRecipientTest extends TestCase
{
    public function testGetEmailRecipient()
    {
        $this->seed([UserRoleSeeder::class, EmailRecipientSeeder::class]);

        $recipients = EmailRecipient::get();
        self::assertNotEmpty($recipients);
        self::assertNotNull($recipients);
    }
}
