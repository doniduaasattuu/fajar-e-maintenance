<?php

namespace Tests\Feature;

use App\Models\Funcloc;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
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
        $this->seed(FunclocSeeder::class);

        $this->get('/funclocs', [])
            ->assertRedirectToRoute('login');
    }

    public function testGetFunclocNotAuthorized()
    {
        $this->seed(FunclocSeeder::class);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->get('/profile')
            ->assertSeeText('Update profile');

        $this->get('/funclocs')
            ->assertSessionHasNoErrors([
                'message' => ['header' => 'Oops!', 'message' => "You're not allowed."]
            ]);
    }

    public function testGetFunclocAuthorized()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/funclocs')
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
        $this->seed(FunclocSeeder::class);

        $this->get('/funcloc-registration')
            ->assertRedirectToRoute('login');
    }

    public function testGetFunclocRegistrationNotAuthorized()
    {
        $this->seed(FunclocSeeder::class);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->get('/funclocs');

        $this->followingRedirects()
            ->get('/funcloc-registration')
            ->assertSeeText('[403] You are not authorized!')
            ->assertSeeText('You are not allowed to perform this operation!.');
    }

    public function testGetFunclocRegistrationAuthorized()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class]);

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
        $this->seed(FunclocSeeder::class);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ])
            ->assertStatus(302)
            ->assertRedirectToRoute('login');
    }

    public function testRegisterFunclocNotAuthorized()
    {
        $this->seed(FunclocSeeder::class);

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

    public function testRegisterFunclocAuthorizedSuccess()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class]);

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
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/funcloc-registration');

        $this->post('/funcloc-register', [
            'id' => 'FP-01 PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ])->assertSessionHasErrors([
            'id' => 'The id field must only contain letters, numbers, and dashes.'
        ]);
    }

    public function testRegisterFunclocInvalidUnderscore()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/funcloc-registration');

        $this->post('/funcloc-register', [
            'id' => 'FP-01_PM3_OCC- PU01',
            'description' => 'SP3.SP-03/M',
        ])->assertSessionHasErrors([
            'id' => 'The id field format is invalid.'
        ]);
    }

    public function testRegisterFunclocInvalidPrefix()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class]);

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
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class]);

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
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class]);

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
        $this->seed(FunclocSeeder::class);

        $this->get('/funcloc-edit/FP-01-CH3-ALM-T089-P085')
            ->assertRedirectToRoute('login');
    }

    public function testGetEditFunclocEmployee()
    {
        $this->seed(FunclocSeeder::class);

        $this->followingRedirects()
            ->withSession([
                'nik' => '55000153',
                'user' => 'Jamal Mirdad'
            ])
            ->get('/funcloc-edit/FP-01-CH3-ALM-T089-P085')
            ->assertSeeText('[403] You are not authorized!')
            ->assertSeeText('You are not allowed to perform this operation!.');
    }

    public function testGetEditFunclocUnregisteredAuthorized()
    {
        $this->seed(FunclocSeeder::class);

        $this->followingRedirects()
            ->withSession([
                'nik' => '55000154',
                'user' => 'Doni Darmawan'
            ])
            ->get('/funcloc-edit/FP-01-PM9-OCC-PU01')
            ->assertSeeText('[404] Not found.')
            ->assertSeeText('The funcloc FP-01-PM9-OCC-PU01 is unregistered.');
    }

    public function testGetFunclocUpdateAuthorized()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class]);

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
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class]);

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
