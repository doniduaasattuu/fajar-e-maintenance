<?php

namespace Tests\Feature;

use App\Data\Modal;
use Database\Seeders\EmailRecipientSeeder;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class EmailControllerTest extends TestCase
{

    public function testGetEmailRecipientPageGuest()
    {
        $this->seed([UserRoleSeeder::class, EmailRecipientSeeder::class]);

        $this
            ->get('/email-recipients')
            ->assertRedirectToRoute('login');
    }

    public function testGetEmailRecipientPageEmployee()
    {
        $this->seed([UserRoleSeeder::class, EmailRecipientSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia'
        ]);

        $this->get('/')
            ->assertSeeText('Hello');

        $this
            ->get('/email-recipients')
            ->assertSessionHas([
                'modal' => new Modal('[403] Forbidden', 'You are not allowed to perform this operation!')
            ]);
    }

    public function testGetEmailRecipientPageAdmin()
    {
        $this->seed([UserRoleSeeder::class, EmailRecipientSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/')
            ->assertSeeText('Hello');

        $this
            ->get('/email-recipients')
            ->assertSessionHas([
                'modal' => new Modal('[403] Forbidden', 'You are not allowed to perform this operation!')
            ]);
    }

    public function testGetEmailRecipientPageSuperAdmin()
    {
        $this->seed([UserRoleSeeder::class, EmailRecipientSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this->get('/')
            ->assertSeeText('Hello');

        $this
            ->get('/email-recipients')
            ->assertSessionDoesntHaveErrors([
                'modal' => new Modal('[403] Forbidden', 'You are not allowed to perform this operation!')
            ])
            ->assertSeeText('Email recipients')
            ->assertSeeText('Email')
            ->assertSeeText('Add')
            ->assertSeeText('Search')
            ->assertSeeText('#')
            ->assertSeeText('Email')
            ->assertSeeText('Name')
            ->assertSeeText('Subscribed at')
            ->assertSeeText('Delete');
    }
}
