<?php

namespace Tests\Feature;

use App\Data\Modal;
use App\Models\EmailRecipient;
use App\Models\User;
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
            ->assertSeeText('prima@gmail.com')
            ->assertSeeText('suryanto@gmail.com')
            ->assertSeeText('jiyantoro@gmail.com')
            ->assertSeeText('Delete');
    }

    public function testGetEmailRecipientPageSuperAdminFilter()
    {
        $this->seed([UserRoleSeeder::class, EmailRecipientSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this->get('/')
            ->assertSeeText('Hello');

        $this
            ->get('/email-recipients?search=toro')
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
            ->assertDontSeeText('prima@gmail.com')
            ->assertDontSeeText('suryanto@gmail.com')
            ->assertSeeText('jiyantoro@gmail.com')
            ->assertSeeText('Displays 1 entries')
            ->assertSeeText('Delete');
    }

    // ADD EMAIL RECIPIENT
    public function testAddRecipientSuccess()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->post('/subscribe', [
                'email' => 'elc357@fajarpaper.com',
                'name' => null,
            ]);

        $this
            ->get('/email-recipients')
            ->assertSeeText('elc357@fajarpaper.com');
    }

    public function testAddRecipientSuccessWithName()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->post('/subscribe', [
                'email' => 'elc357@fajarpaper.com',
                'name' => 'EI2',
            ]);

        $this
            ->get('/email-recipients')
            ->assertSeeText('elc357@fajarpaper.com');
    }

    public function testAddRecipientFailedEmployee()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $user = Auth::user();

        $this
            ->followingRedirects()
            ->get('/email-recipients')
            ->assertSeeText('[403] Forbidden')
            ->assertSeeText('You are not allowed to perform this operation!');

        $this
            ->post('/subscribe', [
                'email' => 'ratin@gmail.com',
                'name' => $user->fullname
            ])
            ->assertStatus(302);

        $subscribe = EmailRecipient::query('ratin@gmail.com')->first();
        self::assertNull($subscribe);
    }

    // DELETE RECIPIENT SUCCESS
    public function testDeleteRecipientSuccess()
    {
        $this->seed([UserRoleSeeder::class, EmailRecipientSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/email-recipients')
            ->assertSeeText('jiyantoro@gmail.com');

        $this
            ->post('/unsubscribe', [
                'email' => 'jiyantoro@gmail.com',
                'name' => 'EI2', // is ignored
            ]);

        $this
            ->get('/email-recipients')
            ->assertDontSeeText('jiyantoro@gmail.com');
    }

    public function testDeleteRecipientFailedNotFound()
    {
        $this->seed([UserRoleSeeder::class, EmailRecipientSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/email-recipients')
            ->assertDontSeeText('joko@gmail.com');

        $this
            ->followingRedirects()
            ->post('/unsubscribe', [
                'email' => 'joko@gmail.com',
            ])
            ->assertSeeText('The selected email is invalid.');
    }

    public function testDeleteRecipientFailedEmployee()
    {
        $this->seed([UserRoleSeeder::class, EmailRecipientSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $user = Auth::user();

        $this
            ->followingRedirects()
            ->get('/email-recipients')
            ->assertSeeText('[403] Forbidden')
            ->assertSeeText('You are not allowed to perform this operation!');

        $this
            ->post('/unsubscribe', [
                'email' => 'jiyantoro@gmail.com',
                'name' => $user->fullname
            ])
            ->assertStatus(302);

        $subscribe = EmailRecipient::query('jiyantoro@gmail.com')->first();
        self::assertNotNull($subscribe);
    }

    // SUBSCRIBE
    public function testSubscribeSuccess()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $user = Auth::user();

        $this
            ->get('/profile')
            ->assertSeeText('Subscribe')
            ->assertDontSeeText('Unsubscribe');

        $this
            ->post('/subscribe', [
                'email' => $user->email_address,
                'name' => $user->fullname,
            ]);

        $this
            ->get('/profile')
            ->assertDontSeeText('Subscribe')
            ->assertSeeText('Unsubscribe');
    }

    public function testSubscribeFailedDontHaveEmail()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '31100162',
            'password' => 'rahasia',
        ]);

        $user = Auth::user();

        $this
            ->get('/profile')
            ->assertDontSeeText('Subscribe')
            ->assertDontSeeText('Unsubscribe');

        $this
            ->followingRedirects()
            ->post('/subscribe', [
                'email' => $user->email_address,
                'name' => $user->fullname,
            ])
            ->assertSeeText('The email field is required.');
    }

    public function testSubscribeFailedInvalidType()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '31100162',
            'password' => 'rahasia',
        ]);

        $user = Auth::user();

        $this
            ->get('/profile')
            ->assertDontSeeText('Subscribe')
            ->assertDontSeeText('Unsubscribe');

        $this
            ->followingRedirects()
            ->post('/subscribe', [
                'email' => 'notemailaddress',
                'name' => $user->fullname,
            ])
            ->assertSeeText('[403] Forbidden')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testSubscribeFailedEmailInvalid()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '31100019',
            'password' => 'rahasia',
        ]);

        $user = Auth::user();
        self::assertEquals($user->email_address, 'jiyantoro@gmail.com');

        $this
            ->get('/profile')
            ->assertSeeText('Subscribe')
            ->assertDontSeeText('Unsubscribe');

        $this
            ->followingRedirects()
            ->post('/subscribe', [
                'email' => 'jiyantoro_new@gmail.com',
                'name' => $user->fullname,
            ])
            ->assertSeeText('[403] Forbidden')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testSubscribeFailedEmailInvalidSuffix()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '31100019',
            'password' => 'rahasia',
        ]);

        $user = Auth::user();
        self::assertEquals($user->email_address, 'jiyantoro@gmail.com');

        $this
            ->get('/profile')
            ->assertSeeText('Subscribe')
            ->assertDontSeeText('Unsubscribe');

        $this
            ->followingRedirects()
            ->post('/subscribe', [
                'email' => 'jiyantoro@yahoo.co.id',
                'name' => $user->fullname,
            ])
            ->assertSeeText('[403] Forbidden')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    // UNSUBSCRIBE
    public function testUnsubscribeSuccess()
    {
        $this->seed([UserRoleSeeder::class, EmailRecipientSeeder::class]);

        Auth::attempt([
            'nik' => '31100019',
            'password' => 'rahasia',
        ]);

        $user = Auth::user();
        self::assertEquals($user->email_address, 'jiyantoro@gmail.com');

        $this
            ->get('/profile')
            ->assertDontSeeText('Subscribe')
            ->assertSeeText('Unsubscribe');

        $this
            ->followingRedirects()
            ->post('/unsubscribe', [
                'email' => $user->email_address,
                'name' => $user->fullname,
            ])
            ->assertDontSeeText('The selected email is invalid.');

        $this
            ->get('/profile')
            ->assertSeeText('Subscribe')
            ->assertDontSeeText('Unsubscribe');
    }

    public function testUnsubscribeSuccessFailedInvalidEmail()
    {
        $this->seed([UserRoleSeeder::class, EmailRecipientSeeder::class]);

        Auth::attempt([
            'nik' => '31100019',
            'password' => 'rahasia',
        ]);

        $user = Auth::user();
        self::assertEquals($user->email_address, 'jiyantoro@gmail.com');

        $this
            ->get('/profile')
            ->assertDontSeeText('Subscribe')
            ->assertSeeText('Unsubscribe');

        $this
            ->followingRedirects()
            ->post('/unsubscribe', [
                'email' => 'jiyantoro_new@gmail.com',
                'name' => $user->fullname,
            ])
            ->assertSeeText('The selected email is invalid.')
            ->assertDontSeeText('Subscribe')
            ->assertSeeText('Unsubscribe');
    }

    public function testUnsubscribeSuccessFailedInvalidSuffix()
    {
        $this->seed([UserRoleSeeder::class, EmailRecipientSeeder::class]);

        Auth::attempt([
            'nik' => '31100019',
            'password' => 'rahasia',
        ]);

        $user = Auth::user();
        self::assertEquals($user->email_address, 'jiyantoro@gmail.com');

        $this
            ->get('/profile')
            ->assertDontSeeText('Subscribe')
            ->assertSeeText('Unsubscribe');

        $this
            ->followingRedirects()
            ->post('/unsubscribe', [
                'email' => 'jiyantoro_new@yahoo.co.id',
                'name' => $user->fullname,
            ])
            ->assertSeeText('The selected email is invalid.')
            ->assertDontSeeText('Subscribe')
            ->assertSeeText('Unsubscribe');
    }
}
