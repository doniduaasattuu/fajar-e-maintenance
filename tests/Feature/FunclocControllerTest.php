<?php

namespace Tests\Feature;

use App\Models\Funcloc;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FunclocControllerTest extends TestCase
{
    // ======================================================
    // =================== FUNCLOC TABLE ====================
    // ======================================================
    public function testGetFunclocGuest()
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/funcloc', [])
            ->assertRedirectToRoute('login');
    }

    public function testGetFunclocNotAuthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->get('/profile')
            ->assertSeeText('Update profile');

        $this->get('/funcloc')
            ->assertSessionHasNoErrors([
                'message' => ['header' => 'Oops!', 'message' => "You're not allowed."]
            ]);
    }

    public function testGetFunclocAuthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/funcloc')
            ->assertSeeText('Table funcloc')
            ->assertSeeText('Filter')
            ->assertDontSeeText('Created at')
            ->assertSeeText('records.');
    }

    // ======================================================
    // ================ FUNCLOC REGISTRATION ================
    // ======================================================
    public function testGetFunclocRegistrationGuest()
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/funcloc-registration')
            ->assertRedirectToRoute('login');
    }

    public function testGetFunclocRegistrationNotAuthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->get('/funcloc');

        $this->followingRedirects()
            ->get('/funcloc-registration')
            ->assertSeeText('[403] You are not authorized!')
            ->assertSeeText('You are not allowed to perform this operation!.');
    }

    public function testGetFunclocRegistrationAuthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/funcloc-registration')
            ->assertSeeText('Funcloc registration')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Description')
            ->assertSeeText('Created at')
            ->assertSeeText('Updated at')
            ->assertSeeText('Submit');
    }

    // ======================================================
    // ================== REGISTER FUNCLOC ==================
    // ======================================================
    public function testRegisterFunclocGuest()
    {
        $this->seed(DatabaseSeeder::class);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ])
            ->assertStatus(302)
            ->assertRedirectToRoute('login');
    }

    public function testRegisterFunclocNotAuthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ])->assertStatus(302)
            ->assertRedirect('/');

        $funcloc = Funcloc::query()->find('FP-01-PM3-OCC-PU01');
        self::assertNull($funcloc);
    }

    public function testRegisterFunclocAuthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/funcloc-registration');

        $response = $this->followingRedirects()
            ->post('/funcloc-register', [
                'id' => 'FP-01-PM3-OCC-PU01',
                'description' => 'SP3.SP-03/M',
            ]);

        $response->assertSeeText('The funcloc successfully registered.');

        $funcloc = Funcloc::query()->find('FP-01-PM3-OCC-PU01');
        self::assertNotNull($funcloc);
    }

    public function testRegisterFunclocInvalid()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/funcloc-registration');

        $this->post('/funcloc-register', [
            'id' => 'FP-01 PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ])->assertSessionHasErrors([
            'id' => 'The id field must only contain letters, numbers, dashes, and underscores.'
        ]);
    }

    public function testRegisterFunclocInvalidPrefix()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/funcloc-registration');

        $this->post('/funcloc-register', [
            'id' => 'PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ])->assertSessionHasErrors([
            'id' => 'The id field must start with one of the following: FP-01.'
        ]);
    }

    public function testRegisterFunclocDescriptionInvalid()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/funcloc-registration');

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'AU',
        ])->assertSessionHasErrors([
            'description' => 'The description field must be at least 3 characters.'
        ]);
    }

    public function testRegisterFunclocDescriptionNull()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/funcloc-registration');

        $response = $this->followingRedirects()
            ->post('/funcloc-register', [
                'id' => 'FP-01-PM3-OCC-PU01',
                'description' => '',
            ]);

        $response->assertSeeText('The funcloc successfully registered.');

        $funcloc = Funcloc::query()->find('FP-01-PM3-OCC-PU01');
        self::assertNotNull($funcloc);
        self::assertEquals('', $funcloc->description);
    }

    public function testRegisterFunclocDuplicate()
    {
        $this->testRegisterFunclocDescriptionNull();

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => '',
        ])->assertSessionHasErrors([
            'id' => 'The selected id is invalid.'
        ]);
    }

    // ======================================================
    // ==================== EDIT FUNCLOC ====================
    // ======================================================
    public function testGetFunclocUpdateGuest()
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/funcloc-edit/FP-01-CH3-ALM-T089-P085')
            ->assertRedirectToRoute('login');
    }

    public function testGetFunclocUpdateAuthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/funcloc-edit/FP-01-CH3-ALM-T089-P085')
            ->assertSeeText('Edit funcloc')
            ->assertSeeText('FP-01-CH3-ALM-T089-P085')
            ->assertSeeText('Updated at')
            ->assertSeeText('Created at')
            ->assertSeeText('Update');
    }

    public function testGetFunclocUpdate()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/funcloc-edit/FP-01-CH3-ALM-T089-P085')
            ->assertSeeText('Edit funcloc')
            ->assertSeeText('Table')
            ->assertSeeText('Description')
            ->assertSeeText('Created at')
            ->assertSeeText('Updated at')
            ->assertSeeText('Update');
    }
}
