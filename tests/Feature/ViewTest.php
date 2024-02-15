<?php

namespace Tests\Feature;

use App\Models\Motor;
use App\Services\FunclocService;
use App\Services\MotorService;
use App\Services\TrafoService;
use App\Services\UserService;
use Database\Seeders\FindingSeeder;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorDetailsSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\TrafoSeeder;
use Exception;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

use function Termwind\ask;

class ViewTest extends TestCase
{
    public function testViewRegistration()
    {
        $this->view('user.registration', [
            'title' => 'Registration',
            'userService' => $this->app->make(UserService::class),
            'action' => '/registration'
        ])
            ->assertSeeText('Registration')
            ->assertSeeText('NIK')
            ->assertSeeText('Password')
            ->assertSeeText('Full name')
            ->assertSeeText('Department')
            ->assertSeeText('EI1')
            ->assertSeeText('EI2')
            ->assertSeeText('EI3')
            ->assertSeeText('EI4')
            ->assertSeeText('EI5')
            ->assertSeeText('EI6')
            ->assertSeeText('EI7')
            ->assertSeeText('Phone number')
            ->assertSeeText('Registration code')
            ->assertSeeText('Sign Up')
            ->assertSeeText('Already have an account ?, Sign in here');
    }

    public function testViewLogin()
    {
        $this->view('user.login', [
            'title' => 'Login'
        ])
            ->assertSeeText('Login')
            ->assertSeeText('NIK')
            ->assertSeeText('Password')
            ->assertSeeText('Sign In')
            ->assertSeeText("Don't have an account ?, Register here");
    }

    public function testViewHome()
    {
        $this->view('maintenance.home', [
            'title' => 'Fajar E-Maintenance'
        ])
            ->assertSeeText('Fajar E-Maintenance')
            ->assertSeeText('We make daily inspection checks easier')
            ->assertSeeText('Scan QR Code')
            ->assertSeeText('Search');
    }

    public function testViewFunclocs()
    {
        $this->seed(FunclocSeeder::class);

        $paginate = DB::table('funclocs')->paginate();

        $this->view('maintenance.funcloc.funcloc', [
            'title' => 'Table funcloc',
            'funclocService' => $this->app->make(FunclocService::class),
            'paginate' => $paginate,
        ])
            ->assertSeeText('Table funcloc')
            ->assertSeeText('Filter')
            ->assertSeeText('The total registered funcloc is')
            ->assertSeeText('Description')
            ->assertSeeText('Updated at')
            ->assertSeeText('Edit');
    }

    public function testViewMotors()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class]);

        $paginate = DB::table('motors')->paginate(perPage: 10, page: 1);

        $this->view('maintenance.motor.motor', [
            'title' => 'Table motor',
            'motorService' => $this->app->make(MotorService::class),
            'paginate' => $paginate,
            'filter' => '',
            'filter_status' => 'All',
        ])
            ->assertSeeText('Table motor')
            ->assertSeeText('New motor')
            ->assertSeeText('Motor status')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Sort field')
            ->assertSeeText('Unique id')
            ->assertSeeText('Updated at')
            ->assertSeeText('Details')
            ->assertSeeText('Edit')
            ->assertSeeText('The total registered motor is')
            ->assertSeeText('The total number displayed is 10 motor.');
    }

    public function testViewEditMotor()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class]);

        $motor = Motor::query()->find('EMO001092');

        $this->view('maintenance.motor.form', [
            'title' => 'Motor details',
            'motor' => $motor,
            'readonly' => true,
            'motorService' => $this->app->make(MotorService::class),
        ])
            ->assertDontSee('/motor-update')
            ->assertSee('readonly')
            ->assertSee('disabled')
            ->assertSee('EMO001092')
            ->assertSee('FP-01-SP5-OCC-FR01')
            ->assertSee('SP5.M-21/M')
            ->assertSee('2568')
            ->assertSee('https://www.safesave.info/MIC.php?id=Fajar-MotorList2568');
    }

    public function testViewEditMotorNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        $motor = Motor::query()->find('EMO000000');

        try {
            $this->view('maintenance.motor.form', [
                'title' => 'Motor details',
                'motor' => $motor,
                'motorService' => $this->app->make(MotorService::class),
            ]);
        } catch (Exception $error) {
            self::assertEquals('Attempt to read property "MotorDetail" on null (View: D:\DEV\FAJAR-E-MAINTENANCE\resources\views\maintenance\motor\details.blade.php) (View: D:\DEV\FAJAR-E-MAINTENANCE\resources\views\maintenance\motor\details.blade.php)', $error->getMessage());
        }
    }

    public function testViewMotorDetails()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        $motor = Motor::query()->find('EMO000105');

        $this->view('maintenance.motor.form', [
            'title' => 'Motor details',
            'motor' => $motor,
            'readonly' => true,
            'motorService' => $this->app->make(MotorService::class),
        ])
            ->assertSee('Motor details')
            ->assertSee('readonly')
            ->assertSee('disabled')
            ->assertSee('10010923')
            ->assertSee('56')
            ->assertSee('https://www.safesave.info/MIC.php?id=Fajar-MotorList56');
    }

    // TRAFO
    public function testViewTrafos()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class]);

        $this->view('maintenance.trafo.trafo', [
            'title' => 'Table trafo',
            'trafoService' => $this->app->make(TrafoService::class),
        ])
            ->assertSeeText('Table trafo')
            ->assertSeeText('New trafo')
            ->assertSeeText('Trafo status')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Sort field')
            ->assertSeeText('Unique id')
            ->assertSeeText('Updated at')
            ->assertSeeText('Details')
            ->assertSeeText('Edit')
            ->assertSeeText('The total registered trafo is')
            ->assertSeeText('ETF001234');
    }
}
