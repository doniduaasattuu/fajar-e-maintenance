<?php

namespace Tests\Feature;

use App\Models\Finding;
use Database\Seeders\FindingSeeder;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class FindingControllerTest extends TestCase
{
    // FINDINGS
    public function testGetFindingsGuest()
    {
        $this->seed(FindingSeeder::class);
        $this->get('/findings')
            ->assertRedirectToRoute('login');
    }

    public function testGetFindingsEmployee()
    {
        $this->seed(FindingSeeder::class);
        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->get('/findings')
            ->assertSeeText('Findings')
            ->assertSeeText('New finding')
            ->assertSeeText('Equipment')
            ->assertSeeText('The total finding is')
            ->assertSeeText('Finding status')
            ->assertSeeText('All')
            ->assertSeeText('Open')
            ->assertSeeText('Closed')
            ->assertSeeText('Status')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Notification')
            ->assertSeeText('Reporter')
            ->assertSeeText('Date')
            ->assertSeeText('Oil leakage on conservator')
            ->assertSeeText('Area licin oli lubrikasi tumpah');
    }

    public function testGetFindingsAuthorized()
    {
        $this->seed(FindingSeeder::class);
        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/findings')
            ->assertSeeText('Findings')
            ->assertSeeText('New finding')
            ->assertSeeText('Equipment')
            ->assertSeeText('The total finding is')
            ->assertSeeText('Finding status')
            ->assertSeeText('All')
            ->assertSeeText('Open')
            ->assertSeeText('Closed')
            ->assertSeeText('Status')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Notification')
            ->assertSeeText('Reporter')
            ->assertSeeText('Date')
            ->assertSeeText('Oil leakage on conservator')
            ->assertSeeText('Area licin oli lubrikasi tumpah');
    }

    // REGISTRATION
    public function testGetFindingRegistrationGuest()
    {
        $this->seed(FindingSeeder::class);
        $this->get('/finding-registration')
            ->assertRedirectToRoute('login');
    }

    public function testGetFindingRegistrationEmployee()
    {
        $this->seed(FindingSeeder::class);
        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->get('/finding-registration')
            ->assertSeeText('New finding')
            ->assertSeeText('Table')
            ->assertSeeText('Area')
            ->assertSeeText('-- Choose --')
            ->assertSeeText('Status')
            ->assertSeeText('Open')
            ->assertSeeText('Closed')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Notification')
            ->assertSeeText('Description')
            ->assertSeeText('Image')
            ->assertSeeText('Maximum upload file size: 5 MB.')
            ->assertSeeText('Submit');
    }

    public function testGetFindingRegistrationAuthorized()
    {
        $this->seed(FindingSeeder::class);
        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/finding-registration')
            ->assertSeeText('New finding')
            ->assertSeeText('Table')
            ->assertSeeText('Area')
            ->assertSeeText('-- Choose --')
            ->assertSeeText('Status')
            ->assertSeeText('Open')
            ->assertSeeText('Closed')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Notification')
            ->assertSeeText('Description')
            ->assertSeeText('Image')
            ->assertSeeText('Maximum upload file size: 5 MB.')
            ->assertSeeText('Submit');
    }

    // AREA
    public function testPostFindingTrafoSuccessWithoutImageEmployee()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->get('/finding-registration');

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
            ])
            ->assertSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);
    }

    public function testPostFindingMotorSuccessWithoutImageEmployee()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->get('/finding-registration');

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'CH3',
                'status' => 'Open',
                'equipment' => 'EMO001056',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
            ])
            ->assertSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);
    }

    public function testPostFindingFailedAreaNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->get('/finding-registration');

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => null,
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
            ])
            ->assertSeeText('The area field is required.')
            ->assertDontSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    public function testPostFindingFailedAreaInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->get('/finding-registration');

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'GK5',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
            ])
            ->assertSeeText('The selected area is invalid.')
            ->assertDontSeeText('The finding successfully saved. ');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    // STATUS
    public function testPostFindingFailedStatusNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->get('/finding-registration');

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'status' => null,
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
            ])
            ->assertSeeText('The status field is required.')
            ->assertDontSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    public function testPostFindingFailedStatusInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->get('/finding-registration');

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'status' => 'Unknown',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
            ])
            ->assertSeeText('The selected status is invalid.')
            ->assertDontSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    // EQUIPMENT
    public function testPostFindingSuccessEquipmentNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->get('/finding-registration');

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'status' => 'Open',
                'equipment' => null,
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
            ])
            ->assertSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);
    }

    public function testPostFindingFailedEquipmentInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->get('/finding-registration');

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'status' => 'Open',
                'equipment' => 'ELP000123',
                'funcloc' => 'FP-01-IN1',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
            ])
            ->assertSeeText('The selected equipment is invalid.')
            ->assertDontSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    // FUNCLOC
    public function testPostFindingSuccessFunclocNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->get('/finding-registration');

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => null,
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
            ])
            ->assertSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);
    }

    public function testPostFindingSuccessFunclocInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->get('/finding-registration');

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-SP9-OCC-PU01',
                'notification' => '10012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
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
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->get('/finding-registration');

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => null,
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
            ])
            ->assertSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);
    }

    public function testPostFindingFailedNotificationLength()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->get('/finding-registration');

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => '100012235',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
            ])
            ->assertSeeText('The notification field must be 8 digits.')
            ->assertDontSeeText('The finding successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);
    }

    public function testPostFindingFailedNotificationInvalidType()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->get('/finding-registration');

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->followingRedirects()
            ->post('/finding-register', [
                'area' => 'IN1',
                'status' => 'Open',
                'equipment' => 'ETF000085',
                'funcloc' => 'FP-01-IN1',
                'notification' => 'abcdefgh',
                'description' => 'Warna silica gel cokelat perlu diganti segera',
                'image' => null,
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
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, FindingSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $finding = Finding::query()->first();

        $this->get("/finding-edit/$finding->id")
            ->assertRedirectToRoute('login');
    }

    public function testGetEditFindingEmployee()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, FindingSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $finding = Finding::query()->first();

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->get("/finding-edit/$finding->id")
            ->assertSeeText('Edit finding')
            ->assertSeeText('Area')
            ->assertSeeText('-- Choose --')
            ->assertSeeText('Status')
            ->assertSeeText('Open')
            ->assertSeeText('Closed')
            ->assertSeeText('Equipment')
            ->assertSee('MGM000481')
            ->assertSeeText('Funcloc')
            ->assertSee('FP-01-PM3-REL-PPRL-PRAR')
            ->assertSeeText('Notification')
            ->assertSee('Doni Darmawan')
            ->assertSeeText('Description')
            ->assertSeeText('Image');
    }

    // UPDATE FINDING
    public function testUpdateFindingGuest()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, FindingSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $finding = Finding::query()->first();

        $this->get("/finding-edit/$finding->id");

        $this
            ->post('/finding-update', [
                'id' => $finding->id,
                'area' => $finding->area,
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
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, FindingSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $finding = Finding::query()->first();

        $this->get("/finding-edit/$finding->id");

        $image = UploadedFile::fake()->image("$finding->id" . '.jpg');

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->followingRedirects()
            ->post('/finding-update', [
                'id' => $finding->id,
                'area' => $finding->area,
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

        $image = Storage::disk('findings')->get($finding->image);
        self::assertNotNull($image);
    }

    public function testUpdateFindingFailedIdIvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, FindingSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $finding = Finding::query()->first();

        $this->get("/finding-edit/$finding->id");

        $image = UploadedFile::fake()->image("$finding->id" . '.jpg');

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->followingRedirects()
            ->post('/finding-update', [
                'id' => uniqid(),
                'area' => $finding->area,
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
