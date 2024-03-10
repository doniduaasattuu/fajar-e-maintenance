<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserRoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    // HOME
    public function testGetHomeGuest()
    {
        $this->get('/')
            ->assertRedirectToRoute('login');
    }

    public function testGetHomeEmployee()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::find('55000135');

        $this
            ->actingAs($user)
            ->get('/')
            ->assertSeeText('Hello Edi Supriadi')
            ->assertSeeText('We make daily inspection checks easier');
    }

    public function testGetHomeAdmin()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::find('55000153');

        $this
            ->actingAs($user)
            ->get('/')
            ->assertSeeText('Hello Jamal Mirdad')
            ->assertSeeText('We make daily inspection checks easier');
    }

    public function testGetHomeSuperAdmin()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::find('55000154');

        $this
            ->actingAs($user)
            ->get('/')
            ->assertSeeText('We make daily inspection checks easier');
    }

    // SCANNER
    public function testGetScannerGuest()
    {
        $this->get('/scanner')
            ->assertRedirectToRoute('login');
    }

    public function testGetScannerEmployee()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::find('55000135');

        $this
            ->actingAs($user)
            ->get('/scanner')
            ->assertStatus(200)
            ->assertSee('Scan');
    }

    public function testGetScannerAdmin()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::find('55000153');

        $this
            ->actingAs($user)
            ->get('/scanner')
            ->assertStatus(200)
            ->assertSee('Scan');
    }

    public function testSearchGuestMotor()
    {
        $this->seed(UserSeeder::class);

        $this->post('/search', [
            'search_equipment' => 'EMO000426'
        ])
            ->assertRedirectToRoute('login');
    }

    public function testSearchMemberMotor()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->post('/search', [
                'search_equipment' => 'EMO000426'
            ])
            ->assertRedirect('/checking-form/Fajar-MotorList1804');
    }

    public function testSearchMemberMotorNull()
    {
        $this->seed(UserSeeder::class);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->followingRedirects()
            ->post('/search', [
                'search_equipment' => null,
            ])
            ->assertSeeText('The submitted value is invalid');
    }

    public function testSearchMemberMotorInvalid()
    {
        $this->seed(UserSeeder::class);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->followingRedirects()
            ->post('/search', [
                'search_equipment' => 'EMO00426'
            ])
            ->assertSeeText('The submitted value is invalid');
    }

    // SEARCH BY UNIQUE ID
    public function testSearchMotorUniqueIdNotFoundAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->followingRedirects()
            ->post('/search', [
                'search_equipment' => 'MOTOR876'
            ])
            ->assertSeeText('The motor with unique id 876 was not found.');
    }

    public function testSearchMotorUniqueIdNotFoundEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->post('/search', [
                'search_equipment' => 'MOTOR876'
            ])
            ->assertSeeText('The motor with unique id 876 was not found.');
    }

    public function testSearchTrafoUniqueIdNotFoundAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->followingRedirects()
            ->post('/search', [
                'search_equipment' => 'TRAFO876'
            ])
            ->assertSeeText('The trafo with unique id 876 was not found.');
    }

    public function testSearchTrafoUniqueIdNotFoundEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->post('/search', [
                'search_equipment' => 'TRAFO876'
            ])
            ->assertSeeText('The trafo with unique id 876 was not found.');
    }

    public function testSearchMotorUniqueIdSuccessAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->post('/search', [
                'search_equipment' => 'MOTOR1804',
            ])
            ->assertRedirect('/checking-form/Fajar-MotorList1804');
    }

    public function testSearchMotorUniqueIdSuccessEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this
            ->post('/search', [
                'search_equipment' => 'MOTOR1804',
            ])
            ->assertRedirect('/checking-form/Fajar-MotorList1804');
    }

    public function testSearchTrafoUniqueIdSuccessAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->post('/search', [
                'search_equipment' => 'TRAfo10'
            ])
            ->assertRedirect('/checking-form/Fajar-TrafoList10');
    }

    public function testSearchTrafoUniqueIdSuccessEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this
            ->post('/search', [
                'search_equipment' => 'TRAfo10'
            ])
            ->assertRedirect('/checking-form/Fajar-TrafoList10');
    }

    public function testSearchInvalidValueEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->post('/search', [
                'search_equipment' => 'P.23'
            ])
            ->assertSeeText('The submitted value is invalid.');
    }
}
