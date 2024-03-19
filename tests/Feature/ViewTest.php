<?php

namespace Tests\Feature;

use App\Models\Motor;
use App\Models\User;
use App\Services\FunclocService;
use App\Services\MotorService;
use App\Services\TrafoService;
use Database\Seeders\DocumentSeeder;
use Database\Seeders\EmailRecipientSeeder;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorDetailsSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\TrafoDetailsSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserRoleSeeder;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testViewRegistration()
    {
        $this
            ->withViewErrors([])
            ->view('auth.registration', [
                'title' => 'Registration',
                'action' => '/registration',
            ])
            ->assertSeeText('Registration')
            ->assertSeeText('NIK')
            ->assertSeeText('Password')
            ->assertSeeText('Fullname')
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
            ->assertSeeText('Already have an account ?')
            ->assertSeeText('Sign in here');
    }

    public function testViewLogin()
    {
        $this
            ->withViewErrors([])
            ->view('auth.login', [
                'title' => 'Login'
            ])
            ->assertSeeText("Login")
            ->assertSeeText('NIK')
            ->assertSeeText('Password')
            ->assertSeeText('Sign In')
            ->assertSeeText("Don't have an account ?,", false)
            ->assertSeeText("Register here");
    }

    public function testViewHome()
    {
        $this->seed([UserRoleSeeder::class]);

        $user = User::find('55000154');

        $this
            ->actingAs($user)
            ->withViewErrors([])
            ->view('maintenance.home', [
                'title' => 'Fajar E-Maintenance'
            ])
            ->assertSeeText('Fajar E-Maintenance')
            ->assertSeeText('Hello Doni Darmawan, welcome to', false)
            ->assertSeeText('We make daily inspection checks easier')
            ->assertSeeText('Scan QR Code')
            ->assertSeeText('Search');
    }

    public function testViewFunclocs()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);
        $user = User::find('55000153');
        $paginator = DB::table('funclocs')->paginate();

        $this
            ->actingAs($user)
            ->withViewErrors([])
            ->view('maintenance.funcloc.funcloc', [
                'title' => 'Funclocs',
                'paginator' => $paginator,
            ])
            ->assertSeeText('Funclocs')
            ->assertSeeText('Filter')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Sort field')
            ->assertSeeText('Edit');
    }

    public function testViewMotors()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class]);
        $user = User::find('55000153');
        $paginator = DB::table('motors')->paginate(perPage: 10, page: 1);

        $this
            ->actingAs($user)
            ->withViewErrors([])
            ->view('maintenance.motor.motor', [
                'title' => 'Motors',
                'paginator' => $paginator,
            ])
            ->assertSeeText('Motors')
            ->assertSeeText('New motor')
            ->assertSeeText('Status')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Unique id')
            ->assertSeeText('Updated at')
            ->assertDontSeeText('Details')
            ->assertSeeText('Edit')
            ->assertSeeText('Displays')
            ->assertSeeText('entries');
    }

    public function testViewEditMotor()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);
        $user = User::find('55000153');
        $motor = Motor::query()->find('EMO001092');

        $this
            ->actingAs($user)
            ->withViewErrors([])
            ->view('maintenance.motor.form', [
                'title' => 'Motor details',
                'motor' => $motor,
            ])
            ->assertDontSee('/motor-update')
            ->assertSee('readonly')
            ->assertSee('EMO001092')
            ->assertSee('FP-01-SP5-OCC-FR01')
            ->assertSee('SP5.M-21/M')
            ->assertSee('2568')
            ->assertSee('id=Fajar-MotorList2568');
    }

    public function testViewEditMotorNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        $motor = Motor::query()->find('EMO000000');

        try {
            $this
                ->withViewErrors([])
                ->view('maintenance.motor.form', [
                    'title' => 'Motor details',
                    'motor' => $motor,
                ]);
        } catch (Exception $error) {
            self::assertNotNull($error);
        }
    }

    public function testViewMotorDetails()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);
        $user = User::find('55000153');
        $motor = Motor::query()->find('EMO000105');

        $this
            ->actingAs($user)
            ->withViewErrors([])
            ->view('maintenance.motor.form', [
                'title' => 'Motor details',
                'motor' => $motor,
            ])
            ->assertSee('Motor details')
            ->assertSee('readonly')
            ->assertSee('10010923')
            ->assertSee('56')
            ->assertSee('id=Fajar-MotorList56');
    }

    // TRAFO
    public function testViewTrafos()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);
        $user = User::find('55000153');
        $paginator = DB::table('trafos')->paginate(perPage: 10, page: 1);

        $this
            ->actingAs($user)
            ->withViewErrors([])
            ->view('maintenance.trafo.trafo', [
                'title' => 'Trafos',
                'paginator' => $paginator,
            ])
            ->assertSeeText('Trafos')
            ->assertSeeText('New trafo')
            ->assertSeeText('Status')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Unique id')
            ->assertSeeText('Updated at')
            ->assertDontSeeText('Details')
            ->assertSeeText('Edit')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('ETF000006');
    }

    // DOCUMENT
    public function testViewDocuments()
    {
        $this->seed([UserRoleSeeder::class, DocumentSeeder::class]);
        $user = User::find('55000154');
        $paginator = DB::table('documents')->paginate(perPage: 10, page: 1);

        $this
            ->actingAs($user)
            ->withViewErrors([])
            ->view('maintenance.document.documents', [
                'title' => 'Documents',
                'paginator' => $paginator,
            ])
            ->assertSeeText('Documents')
            ->assertSeeText('New document')
            ->assertSeeText('Search')
            ->assertSee('Title')
            ->assertSeeText('Dept')
            ->assertSee('EI1')
            ->assertSee('EI2')
            ->assertSee('EI3')
            ->assertSee('EI4')
            ->assertSee('EI5')
            ->assertSee('EI6')
            ->assertSee('EI7')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Title')
            ->assertSeeText('Area')
            ->assertSeeText('Dept')
            ->assertSeeText('Equipment')
            ->assertSeeText('Uploaded by')
            ->assertSeeText('Attach')
            ->assertSeeText('Edit')
            ->assertSeeText('Delete');
    }

    public function testViewProfile()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $user = Auth::user();

        $this
            ->actingAs($user)
            ->withViewErrors([])
            ->view('auth.profile', [
                'title' => 'My profile',
            ])
            ->assertSeeText('My profile')
            ->assertSeeText('NIK')
            ->assertSeeText('Fullname')
            ->assertSeeText('Department')
            ->assertSeeText('Email address')
            ->assertSeeText('Phone number')
            ->assertSeeText('Work center')
            ->assertSeeText('Created at')
            ->assertSeeText('Updated at')
            ->assertSeeText('Email reports')
            ->assertSeeText('55000154')
            ->assertSeeText('Doni Darmawan')
            ->assertSeeText('EI2')
            ->assertSeeText('doni.duaasattuu@gmail.com')
            ->assertSeeText('08983456945')
            ->assertSeeText('Subscribe');
    }

    public function testViewProfileSubscribe()
    {
        $this->seed([UserRoleSeeder::class, EmailRecipientSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $user = Auth::user();

        $this
            ->actingAs($user)
            ->withViewErrors([])
            ->view('auth.profile', [
                'title' => 'My profile',
            ])
            ->assertSeeText('My profile')
            ->assertSeeText('NIK')
            ->assertSeeText('Fullname')
            ->assertSeeText('Department')
            ->assertSeeText('Email address')
            ->assertSeeText('Phone number')
            ->assertSeeText('Work center')
            ->assertSeeText('Created at')
            ->assertSeeText('Updated at')
            ->assertSeeText('Email reports')
            ->assertSeeText('55000154')
            ->assertSeeText('Doni Darmawan')
            ->assertSeeText('EI2')
            ->assertSeeText('doni.duaasattuu@gmail.com')
            ->assertSeeText('08983456945')
            ->assertSeeText('Unsubscribe')
            ->assertDontSeeText('Subscribe');
    }

    public function testViewProfileDoesntHaveEmail()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '31100162',
            'password' => 'rahasia',
        ]);

        $user = Auth::user();

        $this
            ->actingAs($user)
            ->withViewErrors([])
            ->view('auth.profile', [
                'title' => 'My profile',
            ])
            ->assertSeeText('My profile')
            ->assertSeeText('NIK')
            ->assertSeeText('Fullname')
            ->assertSeeText('Department')
            ->assertSeeText('Email address')
            ->assertSeeText('Phone number')
            ->assertSeeText('Work center')
            ->assertSeeText('Created at')
            ->assertSeeText('Updated at')
            ->assertDontSeeText('Email reports')
            ->assertSeeText('31100162')
            ->assertSeeText('Hasan Badri')
            ->assertSeeText('EI2')
            ->assertSeeText('085711412097')
            ->assertDontSeeText('Unsubscribe')
            ->assertDontSeeText('Subscribe');
    }
}
