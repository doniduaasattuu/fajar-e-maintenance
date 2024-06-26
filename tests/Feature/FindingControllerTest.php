<?php

namespace Tests\Feature;

use App\Models\Finding;
use Database\Seeders\FindingSeeder;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FindingControllerTest extends TestCase
{
    // FINDINGS
    public function testGetFindingsGuest()
    {
        $this->get('/findings')
            ->assertRedirectToRoute('login');
    }

    public function testGetFindingsEmployee()
    {
        $this->seed([UserRoleSeeder::class, FindingSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/findings')
            ->assertSeeText('Findings')
            ->assertSeeText('New finding')
            ->assertSeeText('Dept')
            ->assertSeeText('EI1')
            ->assertSeeText('EI2')
            ->assertSeeText('EI3')
            ->assertSeeText('EI4')
            ->assertSeeText('EI5')
            ->assertSeeText('EI6')
            ->assertSeeText('EI7')
            ->assertSeeText('Status')
            ->assertSee('Open')
            ->assertSee('Closed')
            ->assertSeeText('Search')
            ->assertSee('Description')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Area')
            ->assertSeeText('Status')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Notif')
            ->assertSeeText('Reporter')
            ->assertSeeText('Date')
            ->assertSeeText('Edit')
            ->assertSeeText('Delete')
            ->assertSeeText('Inner bearing defect motor refiner PM7');
    }

    public function testGetFindingsAdmin()
    {
        $this->seed([UserRoleSeeder::class, FindingSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/findings')
            ->assertSeeText('Findings')
            ->assertSeeText('New finding')
            ->assertSeeText('Dept')
            ->assertSeeText('EI1')
            ->assertSeeText('EI2')
            ->assertSeeText('EI3')
            ->assertSeeText('EI4')
            ->assertSeeText('EI5')
            ->assertSeeText('EI6')
            ->assertSeeText('EI7')
            ->assertSeeText('Status')
            ->assertSee('Open')
            ->assertSee('Closed')
            ->assertSeeText('Search')
            ->assertSee('Description')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Area')
            ->assertSeeText('Status')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Notif')
            ->assertSeeText('Reporter')
            ->assertSeeText('Date')
            ->assertSeeText('Edit')
            ->assertSeeText('Delete')
            ->assertSeeText('Inner bearing defect motor refiner PM7');
    }

    public function testGetFindingsAdminFilterDept()
    {
        $this->seed([UserRoleSeeder::class, FindingSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/findings?dept=EI3')
            ->assertSeeText('Findings')
            ->assertSeeText('New finding')
            ->assertSeeText('Dept')
            ->assertSeeText('EI1')
            ->assertSeeText('EI2')
            ->assertSeeText('EI3')
            ->assertSeeText('EI4')
            ->assertSeeText('EI5')
            ->assertSeeText('EI6')
            ->assertSeeText('EI7')
            ->assertSeeText('Status')
            ->assertSee('Open')
            ->assertSee('Closed')
            ->assertSeeText('Search')
            ->assertSee('Description')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Area')
            ->assertSeeText('Status')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Notif')
            ->assertSeeText('Reporter')
            ->assertSeeText('Date')
            ->assertSeeText('Edit')
            ->assertSeeText('Delete')
            ->assertSeeText('oli lubrikasi')
            ->assertDontSeeText('Inner bearing defect motor refiner PM7');
    }

    public function testGetFindingsAdminFilterDeptAndStatus()
    {
        $this->seed([UserRoleSeeder::class, FindingSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/findings?dept=EI2&status=Closed')
            ->assertSeeText('Findings')
            ->assertSeeText('New finding')
            ->assertSeeText('Dept')
            ->assertSeeText('EI1')
            ->assertSeeText('EI2')
            ->assertSeeText('EI3')
            ->assertSeeText('EI4')
            ->assertSeeText('EI5')
            ->assertSeeText('EI6')
            ->assertSeeText('EI7')
            ->assertSeeText('Status')
            ->assertSee('Open')
            ->assertSee('Closed')
            ->assertSeeText('Search')
            ->assertSee('Description')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Area')
            ->assertSeeText('Status')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Notif')
            ->assertSeeText('Reporter')
            ->assertSeeText('Date')
            ->assertSeeText('Edit')
            ->assertSeeText('Delete')
            ->assertSeeText('Noise trafo PLN')
            ->assertSeeText('Drop primary voltage')
            ->assertDontSeeText('oli lubrikasi');
    }

    public function testGetFindingsAdminFilterDeptAndStatusAndSearch()
    {
        $this->seed([UserRoleSeeder::class, FindingSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/findings?dept=EI2&status=Closed&search=Drop')
            ->assertSeeText('Findings')
            ->assertSeeText('New finding')
            ->assertSeeText('Dept')
            ->assertSeeText('EI1')
            ->assertSeeText('EI2')
            ->assertSeeText('EI3')
            ->assertSeeText('EI4')
            ->assertSeeText('EI5')
            ->assertSeeText('EI6')
            ->assertSeeText('EI7')
            ->assertSeeText('Status')
            ->assertSee('Open')
            ->assertSee('Closed')
            ->assertSeeText('Search')
            ->assertSee('Description')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Area')
            ->assertSeeText('Status')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Notif')
            ->assertSeeText('Reporter')
            ->assertSeeText('Date')
            ->assertSeeText('Edit')
            ->assertSeeText('Delete')
            ->assertDontSeeText('Noise trafo PLN')
            ->assertSeeText('Drop primary voltage')
            ->assertDontSeeText('oli lubrikasi');
    }

    public function testGetFindingsSuperAdmin()
    {
        $this->seed([UserRoleSeeder::class, FindingSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/findings')
            ->assertSeeText('Findings')
            ->assertSeeText('New finding')
            ->assertSeeText('Dept')
            ->assertSeeText('EI1')
            ->assertSeeText('EI2')
            ->assertSeeText('EI3')
            ->assertSeeText('EI4')
            ->assertSeeText('EI5')
            ->assertSeeText('EI6')
            ->assertSeeText('EI7')
            ->assertSeeText('Status')
            ->assertSee('Open')
            ->assertSee('Closed')
            ->assertSeeText('Search')
            ->assertSee('Description')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Area')
            ->assertSeeText('Status')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Notif')
            ->assertSeeText('Reporter')
            ->assertSeeText('Date')
            ->assertSeeText('Edit')
            ->assertSeeText('Delete')
            ->assertSeeText('Inner bearing defect motor refiner PM7');
    }

    // REGISTRATION
    public function testGetFindingRegistrationGuest()
    {
        $this->get('/finding-registration')
            ->assertRedirectToRoute('login');
    }

    public function testGetFindingRegistrationEmployee()
    {
        $this->seed([UserRoleSeeder::class, FindingSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/finding-registration')
            ->assertSeeText('New finding')
            ->assertSeeText('Findings')
            ->assertSeeText('Area')
            ->assertDontSeeText('Department *')
            ->assertSeeText('Status *')
            ->assertSee('Open')
            ->assertSee('Closed')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Notif')
            ->assertSeeText('Description *')
            ->assertSeeText('Image')
            ->assertSeeText('Maximum upload file size: 5 MB.')
            ->assertSeeText('Submit');
    }

    public function testGetFindingRegistrationAdmin()
    {
        $this->seed([UserRoleSeeder::class, FindingSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/finding-registration')
            ->assertSeeText('New finding')
            ->assertSeeText('Findings')
            ->assertSeeText('Area')
            ->assertDontSeeText('Department *')
            ->assertSeeText('Status *')
            ->assertSee('Open')
            ->assertSee('Closed')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Notif')
            ->assertSeeText('Description *')
            ->assertSeeText('Image')
            ->assertSeeText('Maximum upload file size: 5 MB.')
            ->assertSeeText('Submit');
    }

    public function testGetFindingRegistrationSuperAdmin()
    {
        $this->seed([UserRoleSeeder::class, FindingSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/finding-registration')
            ->assertSeeText('New finding')
            ->assertSeeText('Findings')
            ->assertSeeText('Area')
            ->assertSeeText('Department *')
            ->assertSeeText('Status *')
            ->assertSee('Open')
            ->assertSee('Closed')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Notif')
            ->assertSeeText('Description *')
            ->assertSeeText('Image')
            ->assertSeeText('Maximum upload file size: 5 MB.')
            ->assertSeeText('Submit');
    }

    // AREA
    public function testPostFindingTrafoSuccessWithoutImageEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'department' => 'EI2',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);
        self::assertEquals('Edi Supriadi', $findings->first()->reporter);
    }

    public function testPostFindingMotorSuccessWithoutImageAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'CH3',
                'department' => 'EI2',
                'status' => 'Open',
                'equipment' => 'EMO001056',
                'funcloc' => 'FP-01-BO3-CAS-COM2',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);
        self::assertEquals('Jamal Mirdad', $findings->first()->reporter);
    }

    public function testPostFindingMotorSuccessWithoutImageSuperAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'CH3',
                'department' => 'EI2',
                'status' => 'Open',
                'equipment' => 'EMO001056',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);
        self::assertEquals('Doni Darmawan', $findings->first()->reporter);
    }

    public function testPostFindingFailedAreaNullSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => null,
                'department' => 'EI2',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertDontSeeText('The area field is required.')
            ->assertSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);
    }

    public function testPostFindingFailedAreaInvalidLengthMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => '1',
                'department' => 'EI2',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The area field must be at least 3 characters.')
            ->assertDontSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    public function testPostFindingFailedAreaInvalidLengthMax()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'This is invalid finding area',
                'department' => 'EI2',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The area field must not be greater than 15 characters.')
            ->assertDontSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    public function testPostFindingFailedDepartmentNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'PM3',
                'department' => null,
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The department field is required.')
            ->assertDontSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    public function testPostFindingFailedDepartmentInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'PM3',
                'department' => 'EI9',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The selected department is invalid.')
            ->assertDontSeeText('The finding successfully saved. ');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    // STATUS
    public function testPostFindingFailedStatusNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'department' => 'EI2',
                'status' => null,
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The status field is required.')
            ->assertDontSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    public function testPostFindingFailedStatusInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'department' => 'EI2',
                'status' => 'Unknown',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The selected status is invalid.')
            ->assertDontSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    // SORT FIELD
    public function testPostFindingSuccessSortFieldNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'department' => 'EI2',
                'status' => 'Open',
                'equipment' => null,
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);
    }

    public function testPostFindingFailedSortFieldInvalidMinLength()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'department' => 'EI2',
                'status' => 'Open',
                'sort_field' => 'P3',
                'equipment' => 'ELP000123',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The sort field field must be at least 3 characters.')
            ->assertDontSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    public function testPostFindingFailedSortFieldInvalidMaxLength()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'department' => 'EI2',
                'status' => 'Open',
                'sort_field' => 'This is invalid finding sort field because length is more than fifty',
                'equipment' => 'ELP000123',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The sort field field must not be greater than 50 characters.')
            ->assertDontSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    // EQUIPMENT
    public function testPostFindingSuccessEquipmentNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'department' => 'EI2',
                'status' => 'Open',
                'equipment' => null,
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);
    }

    // FUNCLOC
    public function testPostFindingSuccessFunclocNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'department' => 'EI2',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => null,
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);
    }

    public function testPostFindingSuccessFunclocInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'department' => 'EI2',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-SP9-OCC-PU01',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The selected funcloc is invalid.')
            ->assertDontSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    // NOTIFICATION
    public function testPostFindingSuccessNotificationNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'department' => 'EI2',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => null,
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);
    }

    public function testPostFindingFailedNotificationLength()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'department' => 'EI2',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '100012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The notification field must be 8 digits.')
            ->assertDontSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    public function testPostFindingFailedNotificationInvalidType()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/finding-registration');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'department' => 'EI2',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => 'abcdefgh',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
                'reporter' => Auth::user()->fullname,
            ])
            ->assertSeeText('The notification field must be a number.')
            ->assertDontSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    // EDIT FINDING
    public function testGetEditFindingGuest()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, FindingSeeder::class]);

        $finding = Finding::query()->first();

        $this->get("/finding-edit/$finding->id")
            ->assertRedirectToRoute('login');
    }

    public function testGetEditFindingEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, FindingSeeder::class]);

        $finding = Finding::query()->first();

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get("/finding-edit/$finding->id")
            ->assertSeeText('Edit finding')
            ->assertSeeText('Area')
            ->assertSeeText('Status')
            ->assertSeeText('Open')
            ->assertSeeText('Closed')
            ->assertSeeText('Equipment')
            ->assertSee('MGM000481')
            ->assertSeeText('Funcloc')
            ->assertSee('FP-01-PM3-REL-PPRL-PRAR')
            ->assertSeeText('Notif')
            ->assertSee('Doni Darmawan')
            ->assertSeeText('Description')
            ->assertSeeText('Image');
    }

    // UPDATE FINDING
    public function testUpdateFindingGuest()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, FindingSeeder::class]);

        $finding = Finding::query()->first();

        $this->get("/finding-edit/$finding->id");

        $this
            ->post('/finding-update', [
                'id' => $finding->id,
                'area' => $finding->area,
                'department' => 'EI2',
                'status' => $finding->status,
                'equipment' => $finding->equipment,
                'funcloc' => $finding->funcloc,
                'notification' => $finding->notification,
                'reporter' => $finding->reporter,
                'description' => $finding->description,
                'image' => $finding->image,
                'created_at' => $finding->created_at,
                'updated_at' => $finding->updated_at,
            ])
            ->assertRedirectToRoute('login');
    }

    public function testUpdateFindingSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, FindingSeeder::class]);

        $finding = Finding::query()->first();

        $this->get("/finding-edit/$finding->id");

        $image = UploadedFile::fake()->image("$finding->id" . '.jpg');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-update', [
                'id' => $finding->id,
                'area' => $finding->area,
                'department' => 'EI2',
                'status' => $finding->status,
                'equipment' => $finding->equipment,
                'funcloc' => $finding->funcloc,
                'notification' => $finding->notification,
                'reporter' => $finding->reporter,
                'description' => $finding->description,
                'image' => $image,
                'created_at' => $finding->created_at,
                'updated_at' => $finding->updated_at,
            ])
            ->assertSeeText('The finding successfully updated.');

        // $image = Storage::disk('findings')->get($finding->image);
        $image = public_path("/findings/$finding->image");
        self::assertNotNull($image);
    }

    public function testUpdateFindingFailedIdIvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, FindingSeeder::class]);

        $finding = Finding::query()->first();
        self::assertNotNull($finding);

        $this->get("/finding-edit/$finding->id");

        $image = UploadedFile::fake()->image("$finding->id" . '.jpg');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->post('/finding-update', [
                'id' => uniqid(),
                'area' => $finding->area,
                'department' => 'EI2',
                'status' => $finding->status,
                'equipment' => $finding->equipment,
                'funcloc' => $finding->funcloc,
                'notification' => $finding->notification,
                'reporter' => $finding->reporter,
                'description' => $finding->description,
                'image' => $image,
                'created_at' => $finding->created_at,
                'updated_at' => $finding->updated_at,
            ])
            ->assertSeeText('The selected id is invalid.');
    }
}
