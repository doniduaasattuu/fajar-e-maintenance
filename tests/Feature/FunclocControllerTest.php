<?php

namespace Tests\Feature;

use App\Models\Funcloc;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FunclocControllerTest extends TestCase
{
    // ======================================================
    // =================== FUNCLOC TABLE ====================
    // ======================================================
    public function testGetFunclocGuest()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        $this->get('/funclocs')
            ->assertRedirectToRoute('login');
    }

    public function testGetFunclocEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this->get('/funclocs')
            ->assertDontSeeText('Edit');
    }

    public function testGetFunclocAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->get('/funclocs')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Search')
            ->assertSeeText('Edit')
            ->assertDontSeeText('Created at')
            ->assertSeeText('Displays')
            ->assertSeeText('entries');
    }

    public function testGetFunclocAdminFilterSearch()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->get('/funclocs?search=FP-01-PM3')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Search')
            ->assertSeeText('Edit')
            ->assertDontSeeText('Created at')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('FP-01-PM3')
            ->assertSeeText('FP-01-PM3-BRS-T037-P061')
            ->assertSeeText('FP-01-PM3-REL-PPRL-PRAR')
            ->assertDontSeeText('FP-01-PM2');
    }

    // ======================================================
    // ================ FUNCLOC REGISTRATION ================
    // ======================================================
    public function testGetFunclocRegistrationGuest()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        $this->get('/funcloc-registration')
            ->assertRedirectToRoute('login');
    }

    public function testGetFunclocRegistrationEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this->get('/funclocs');

        $this
            ->followingRedirects()
            ->get('/funcloc-registration')
            ->assertSeeText('[403] Forbidden')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testGetFunclocRegistrationAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->get('/funcloc-registration')
            ->assertSeeText('Funcloc registration')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Sort field')
            ->assertSeeText('Created at')
            ->assertSeeText('Updated at')
            ->assertDontSeeText('Save changes')
            ->assertSeeText('Submit');
    }

    // ======================================================
    // ================== REGISTER FUNCLOC ==================
    // ======================================================
    public function testRegisterFunclocGuest()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
        ])
            ->assertStatus(302)
            ->assertRedirectToRoute('login');
    }

    public function testRegisterFunclocEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->post('/funcloc-register', [
                'id' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
            ])
            ->assertSeeText('[403] Forbidden')
            ->assertSeeText('You are not allowed to perform this operation!');

        $funcloc = Funcloc::query()->find('FP-01-PM3-OCC-PU01');
        self::assertNull($funcloc);
    }

    public function testRegisterFunclocAdminSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->get('/funcloc-registration');

        $response = $this->followingRedirects()
            ->post('/funcloc-register', [
                'id' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
            ]);

        $response->assertSeeText('The funcloc successfully registered.');

        $funcloc = Funcloc::query()->find('FP-01-PM3-OCC-PU01');
        self::assertNotNull($funcloc);
    }

    public function testRegisterFunclocInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->get('/funcloc-registration');

        $this->post('/funcloc-register', [
            'id' => 'FP-01 PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
        ])->assertSessionHasErrors([
            'id' => 'The id field must only contain letters, numbers, and dashes.'
        ]);
    }

    public function testRegisterFunclocInvalidUnderscore()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->get('/funcloc-registration');

        $this->post('/funcloc-register', [
            'id' => 'FP-01_PM3_OCC- PU01',
            'sort_field' => 'SP3.SP-03/M',
        ])->assertSessionHasErrors([
            'id' => 'The id field format is invalid.'
        ]);
    }

    public function testRegisterFunclocInvalidPrefix()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->get('/funcloc-registration');

        $this->post('/funcloc-register', [
            'id' => 'PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
        ])->assertSessionHasErrors([
            'id' => 'The id field must start with one of the following: FP-01.'
        ]);
    }

    public function testRegisterFunclocSortFieldInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->get('/funcloc-registration');

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'AU',
        ])->assertSessionHasErrors([
            'sort_field' => 'The sort field field must be at least 3 characters.'
        ]);
    }

    public function testRegisterFunclocSortFieldNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->get('/funcloc-registration');

        $response = $this->followingRedirects()
            ->post('/funcloc-register', [
                'id' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => '',
            ]);

        $response->assertSeeText('The funcloc successfully registered.');

        $funcloc = Funcloc::query()->find('FP-01-PM3-OCC-PU01');
        self::assertNotNull($funcloc);
        self::assertEquals('', $funcloc->description);
    }

    public function testRegisterFunclocDuplicate()
    {
        $this->testRegisterFunclocSortFieldNull();

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => '',
        ])->assertSessionHasErrors([
            'id' => 'The selected id is invalid.'
        ]);
    }

    // ======================================================
    // ==================== EDIT FUNCLOC ====================
    // ======================================================
    public function testGetFunclocUpdateGuest()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        $this->get('/funcloc-edit/FP-01-CH3-ALM-T089-P085')
            ->assertRedirectToRoute('login');
    }

    public function testGetEditFunclocEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this->followingRedirects()
            ->get('/funcloc-edit/FP-01-CH3-ALM-T089-P085')
            ->assertSeeText('[403] Forbidden')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testGetEditFunclocUnregisteredAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->followingRedirects()

            ->get('/funcloc-edit/FP-01-PM9-OCC-PU01')
            ->assertSeeText('[404] Not found')
            ->assertSeeText('The funcloc FP-01-PM9-OCC-PU01 is unregistered.');
    }

    public function testGetFunclocUpdateAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->get('/funcloc-edit/FP-01-CH3-ALM-T089-P085')
            ->assertSeeText('Edit funcloc')
            ->assertSeeText('FP-01-CH3-ALM-T089-P085')
            ->assertSeeText('Updated at')
            ->assertSeeText('Created at')
            ->assertDontSeeText('Submit')
            ->assertSeeText('Save changes');
    }

    public function testGetFunclocUpdate()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/funcloc-edit/FP-01-CH3-ALM-T089-P085')
            ->assertSeeText('Edit funcloc')
            ->assertSeeText('Table')
            ->assertSeeText('Sort field')
            ->assertSeeText('Created at')
            ->assertSeeText('Updated at')
            ->assertSeeText('Update');
    }
}
