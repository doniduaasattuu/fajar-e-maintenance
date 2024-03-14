<?php

namespace Tests\Feature;

use App\Models\Motor;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorDetailsSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class MotorControllerTest extends TestCase
{
    public function testGetMotorsGuest()
    {
        $this->get('/motors')
            ->assertRedirect('/login');
    }

    public function testGetMotorsEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia'
        ]);

        $this->get('/motors')
            ->assertSeeText('Motors')
            ->assertDontSeeText('New motor')
            ->assertDontSeeText('Install / Dismantle')
            ->assertSeeText('Search')
            ->assertSeeText('Status')
            ->assertSee('Installed')
            ->assertSee('Available')
            ->assertSee('Repaired')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Id')
            ->assertSeeText('Status')
            ->assertSeeText('Functional location')
            ->assertSeeText('Unique id')
            ->assertSeeText('Updated at')
            ->assertSeeText('Details');
    }

    public function testGetMotorsAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motors')
            ->assertSeeText('Motors')
            ->assertSeeText('New motor')
            ->assertSeeText('Install / Dismantle')
            ->assertSeeText('Search')
            ->assertSeeText('Status')
            ->assertSee('Installed')
            ->assertSee('Available')
            ->assertSee('Repaired')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Id')
            ->assertSeeText('Status')
            ->assertSeeText('Functional location')
            ->assertSeeText('Unique id')
            ->assertSeeText('Updated at')
            ->assertSeeText('Edit')
            ->assertDontSeeText('Details');
    }

    public function testGetMotorsAdminFilterSearch()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motors?search=MGM')
            ->assertSeeText('Motors')
            ->assertSeeText('New motor')
            ->assertSeeText('Install / Dismantle')
            ->assertSeeText('Search')
            ->assertSeeText('Status')
            ->assertSee('Installed')
            ->assertSee('Available')
            ->assertSee('Repaired')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Id')
            ->assertSeeText('Status')
            ->assertSeeText('Functional location')
            ->assertSeeText('Unique id')
            ->assertSeeText('Updated at')
            ->assertSeeText('MGM000481')
            ->assertDontSeeText('EMO000426')
            ->assertSeeText('Edit')
            ->assertDontSeeText('Details');
    }

    public function testGetMotorsAdminFilterStatus()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motors?status=Available')
            ->assertSeeText('Motors')
            ->assertSeeText('New motor')
            ->assertSeeText('Install / Dismantle')
            ->assertSeeText('Search')
            ->assertSeeText('Status')
            ->assertSee('Installed')
            ->assertSee('Available')
            ->assertSee('Repaired')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Id')
            ->assertSeeText('Status')
            ->assertSeeText('Functional location')
            ->assertSeeText('Unique id')
            ->assertSeeText('Updated at')
            ->assertSeeTextInOrder(['EMO000008', 'EMO000023', 'EMO000042', 'EMO000075', 'EMO000094'])
            ->assertDontSeeText('EMO000426')
            ->assertDontSeeText('EMO000060')
            ->assertSeeText('Edit')
            ->assertDontSeeText('Details');
    }

    public function testGetMotorsAdminFilterSearchAndStatus()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motors?search=0000&status=Installed')
            ->assertSeeText('Motors')
            ->assertSeeText('New motor')
            ->assertSeeText('Install / Dismantle')
            ->assertSeeText('Search')
            ->assertSeeText('Status')
            ->assertSee('Installed')
            ->assertSee('Available')
            ->assertSee('Repaired')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Id')
            ->assertSeeText('Status')
            ->assertSeeText('Functional location')
            ->assertSeeText('Unique id')
            ->assertSeeText('Updated at')
            ->assertSeeTextInOrder(['EMO000038', 'EMO000060', 'EMO000061'])
            ->assertDontSeeText('EMO000426')
            ->assertDontSeeText('EMO000075')
            ->assertDontSeeText('EMO000042')
            ->assertSeeText('Edit')
            ->assertDontSeeText('Details');
    }

    public function testGetMotorsSuperAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this->get('/motors')
            ->assertSeeText('Motors')
            ->assertSeeText('New motor')
            ->assertSeeText('Install / Dismantle')
            ->assertSeeText('Search')
            ->assertSeeText('Status')
            ->assertSee('Installed')
            ->assertSee('Available')
            ->assertSee('Repaired')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Id')
            ->assertSeeText('Status')
            ->assertSeeText('Functional location')
            ->assertSeeText('Unique id')
            ->assertSeeText('Updated at')
            ->assertSeeText('Edit')
            ->assertDontSeeText('Details');
    }

    // EDIT MOTOR
    public function testGetEditMotorGuest()
    {
        $this->get('/motor-edit/EMO000008')
            ->assertRedirectToRoute('login');
    }

    public function testGetEditMotorEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/motor-edit/EMO000008')
            ->assertSeeText('[403] Forbidden')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testGetEditMotorUregisteredAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->followingRedirects()
            ->get('/motor-edit/EMO000001')
            ->assertSeeText('[404] Not found')
            ->assertSeeText('The motor EMO000001 is unregistered.');
    }

    public function testGetEditMotorAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/motor-edit/EMO000008')
            ->assertSeeText('Edit motor')
            ->assertSeeText('Status')
            ->assertSeeText('Installed')
            ->assertSeeText('Repaired')
            ->assertSeeText('Available')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Sort field')
            ->assertSeeText('Description')
            ->assertSee('AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3')
            ->assertSeeText('Material number')
            ->assertSee('10010591')
            ->assertSeeText('Unique id')
            ->assertSee('4592')
            ->assertSeeText('EMO000008')
            ->assertSeeText('Qr code link')
            ->assertSeeText('Created at')
            ->assertDontSeeText('Submit')
            ->assertSeeText('Update')
            ->assertDontSeeText('[403] Forbidden')
            ->assertDontSeeText('You are not allowed to perform this operation!');
    }

    public function testGetMotorDetailsGuest()
    {
        $this->get('/motor-details/EMO000105')
            ->assertRedirectToRoute('login');
    }

    public function testGetMotorDetailsEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-details/EMO000105')
            ->assertSeeText('Motor details')
            ->assertSeeText('Status')
            ->assertSee('Repaired')
            ->assertSeeText('Funcloc')
            ->assertDontSee('FP-01')
            ->assertSeeText('Description')
            ->assertSee('AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3')
            ->assertSeeText('Material number')
            ->assertSee('10010923')
            ->assertSeeText('Unique id')
            ->assertSee('56')
            ->assertSeeText('Qr code link')
            ->assertSee('id=Fajar-MotorList56')
            ->assertSeeText('Created at')
            ->assertSeeText('Updated at')
            ->assertSee('disabled');
    }

    public function testGetMotorDetailsAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-details/EMO000105')
            ->assertSeeText('Motor details')
            ->assertSeeText('Status')
            ->assertSee('Repaired')
            ->assertSeeText('Funcloc')
            ->assertDontSee('FP-01')
            ->assertSeeText('Description')
            ->assertSee('AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3')
            ->assertSeeText('Material number')
            ->assertSee('10010923')
            ->assertSeeText('Unique id')
            ->assertSee('56')
            ->assertSeeText('Qr code link')
            ->assertSee('id=Fajar-MotorList56')
            ->assertSeeText('Created at')
            ->assertSeeText('Updated at')
            ->assertSee('disabled');
    }

    public function testGetMotorDetailsUregisteredAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/motors');

        $this
            ->followingRedirects()
            ->get('/motor-edit/EMO000001')
            ->assertSeeText('[404] Not found')
            ->assertSeeText('The motor EMO000001 is unregistered.');
    }

    // UPDATE
    public function testUpdateMotorGuest()
    {
        $this->post('/motor-update', [
            'status' => 'Installed',
            'funcloc' => null,
            'sort_field' => null,
        ])
            ->assertRedirectToRoute('login');
    }

    public function testUpdateMotorUnregisteredAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/motor-edit/EMO000105');

        $this
            ->post('/motor-update', [
                'id' => 'EMO000000',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'id=Fajar-MotorList56',
            ])
            ->assertSessionHasErrors([
                'id' => 'The selected id is invalid.',
            ]);
    }

    public function testUpdateMotorInvalidIdLength()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/motor-edit/EMO000105');

        $this
            ->post('/motor-update', [
                'id' => 'EMO00105',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'id=Fajar-MotorList56',
            ])
            ->assertSessionHasErrors([
                'id' => 'The id field must be 9 characters.',
            ]);
    }

    public function testUpdateMotorInstalledFunclocAndSortfieldNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/motor-edit/EMO000105');

        $this
            ->post('/motor-update', [
                'id' => 'EMO000105',
                'status' => 'Installed',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'id=Fajar-MotorList56',
                'motor_detail' => null,
                'manufacturer' => null,
                'serial_number' => null,
                'type' => null,
                'power_rate' => null,
                'power_unit' => null,
                'voltage' => null,
                'electrical_current' => null,
                'current_nominal' => null,
                'frequency' => null,
                'pole' => null,
                'rpm' => null,
                'bearing_de' => null,
                'bearing_nde' => null,
                'frame_type' => null,
                'shaft_diameter' => null,
                'phase_supply' => null,
                'cos_phi' => null,
                'efficiency' => null,
                'ip_rating' => null,
                'insulation_class' => null,
                'duty' => null,
                'connection_type' => null,
                'nipple_grease' => null,
                'greasing_type' => null,
                'greasing_qty_de' => null,
                'greasing_qty_nde' => null,
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field is required when status is Installed.',
                'sort_field' => 'The sort field field is required when status is Installed.',
            ]);
    }

    public function testUpdateMotorRepairedFunclocAndSortfieldNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/motor-edit/EMO000105');

        $this->followingRedirects()
            ->post('/motor-update', [
                'id' => 'EMO000105',
                'status' => 'Repaired',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'id=Fajar-MotorList56',
                'motor_detail' => 'EMO000105',
                'manufacturer' => null,
                'serial_number' => null,
                'type' => null,
                'power_rate' => null,
                'power_unit' => null,
                'voltage' => null,
                'electrical_current' => null,
                'current_nominal' => null,
                'frequency' => null,
                'pole' => null,
                'rpm' => null,
                'bearing_de' => null,
                'bearing_nde' => null,
                'frame_type' => null,
                'shaft_diameter' => null,
                'phase_supply' => null,
                'cos_phi' => null,
                'efficiency' => null,
                'ip_rating' => null,
                'insulation_class' => null,
                'duty' => null,
                'connection_type' => null,
                'nipple_grease' => null,
                'greasing_type' => null,
                'greasing_qty_de' => null,
                'greasing_qty_nde' => null,
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSeeText('The motor successfully updated.');
    }

    public function testUpdateMotorAvailableFunclocAndSortfieldNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/motor-edit/EMO000105');

        $this->followingRedirects()
            ->post('/motor-update', [
                'id' => 'EMO000105',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'id=Fajar-MotorList56',
                'motor_detail' => 'EMO000105',
                'manufacturer' => null,
                'serial_number' => null,
                'type' => null,
                'power_rate' => null,
                'power_unit' => null,
                'voltage' => null,
                'electrical_current' => null,
                'current_nominal' => null,
                'frequency' => null,
                'pole' => null,
                'rpm' => null,
                'bearing_de' => null,
                'bearing_nde' => null,
                'frame_type' => null,
                'shaft_diameter' => null,
                'phase_supply' => null,
                'cos_phi' => null,
                'efficiency' => null,
                'ip_rating' => null,
                'insulation_class' => null,
                'duty' => null,
                'connection_type' => null,
                'nipple_grease' => null,
                'greasing_type' => null,
                'greasing_qty_de' => null,
                'greasing_qty_nde' => null,
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSeeText('The motor successfully updated.');
    }

    public function testUpdateMotorFunclocInvalidPrefix()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/motor-edit/EMO000105');

        $this
            ->post('/motor-update', [
                'id' => 'EMO000105',
                'status' => 'Installed',
                'funcloc' => 'SP3-OCC-PU02',
                'sort_field' => 'SP3.SP-04/M',
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'id=Fajar-MotorList56',
            ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field must start with one of the following: FP-01.',
            ]);
    }

    public function testUpdateMotorFunclocInvalidLengthMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/motor-edit/EMO000105');

        $this
            ->post('/motor-update', [
                'id' => 'EMO000105',
                'status' => 'Installed',
                'funcloc' => 'FP-01-SP',
                'sort_field' => 'SP3.SP-04/M',
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'id=Fajar-MotorList56',
            ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field must be at least 9 characters.',
            ]);
    }

    public function testUpdateMotorFunclocInvalidLengthMax()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/motor-edit/EMO000105');

        $this
            ->post('/motor-update', [
                'id' => 'EMO000105',
                'status' => 'Installed',
                'funcloc' => 'FP-01-SP3-INVALID-LENGTH-MAX-MORE-THAN-FIFTY-CHARACTER-CANNOT-UPDATE-AN-MOTOR-STATUS',
                'sort_field' => 'SP3.SP-04/M',
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'id=Fajar-MotorList56',
            ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field must not be greater than 50 characters.',
            ]);
    }

    public function testUpdateMotorSortfieldNullStatusInstalled()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => null,
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => null,
                'unique_id' => '2008',
                'qr_code_link' => 'id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field is required when status is Installed.',
            ]);
    }

    public function testUpdateMotorSortfieldInvalidLengthMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'Y',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => null,
                'unique_id' => '2008',
                'qr_code_link' => 'id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field must be at least 3 characters.',
            ]);
    }

    public function testUpdateMotorSortfieldInvalidLengthMax()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'SORT-FIELD-INVALID-LENGTH-MAX-MORE-THAN-FIFTY-CHARACTER-CANNOT-UPDATE-AN-MOTOR-STATUS-BECAUSE IS TOO LOOONG',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => null,
                'unique_id' => '2008',
                'qr_code_link' => 'id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field must not be greater than 50 characters.',
            ]);
    }

    public function testUpdateMotorDescriptionNullSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/motor-edit/EMO001056');

        $this->followingRedirects()
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => null,
                'material_number' => null,
                'unique_id' => '2008',
                'qr_code_link' => 'id=Fajar-MotorList2008',
                'motor_detail' => 'EMO001056',
                'manufacturer' => null,
                'serial_number' => null,
                'type' => null,
                'power_rate' => null,
                'power_unit' => null,
                'voltage' => null,
                'electrical_current' => null,
                'current_nominal' => null,
                'frequency' => null,
                'pole' => null,
                'rpm' => null,
                'bearing_de' => null,
                'bearing_nde' => null,
                'frame_type' => null,
                'shaft_diameter' => null,
                'phase_supply' => null,
                'cos_phi' => null,
                'efficiency' => null,
                'ip_rating' => null,
                'insulation_class' => null,
                'duty' => null,
                'connection_type' => null,
                'nipple_grease' => null,
                'greasing_type' => null,
                'greasing_qty_de' => null,
                'greasing_qty_nde' => null,
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSeeText('The motor successfully updated.');
    }

    public function testUpdateMotorDescriptionInvalidLengthMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC',
                'material_number' => null,
                'unique_id' => '2008',
                'qr_code_link' => 'id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'description' => 'The description field must be at least 3 characters.',
            ]);
    }

    public function testUpdateMotorDescriptionInvalidLengthMax()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3,INVALID-LENGTH-MAX-MORE-THAN-FIFTY-CHARACTER-CANNOT-UPDATE-AN-MOTOR-STATUS',
                'material_number' => null,
                'unique_id' => '2008',
                'qr_code_link' => 'id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'description' => 'The description field must not be greater than 50 characters.',
            ]);
    }

    public function testUpdateMotorMaterialNumberNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-edit/EMO001056');

        $this->followingRedirects()
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => null,
                'unique_id' => '2008',
                'qr_code_link' => 'id=Fajar-MotorList2008',
                'motor_detail' => 'EMO001056',
                'manufacturer' => null,
                'serial_number' => null,
                'type' => null,
                'power_rate' => null,
                'power_unit' => null,
                'voltage' => null,
                'electrical_current' => null,
                'current_nominal' => null,
                'frequency' => null,
                'pole' => null,
                'rpm' => null,
                'bearing_de' => null,
                'bearing_nde' => null,
                'frame_type' => null,
                'shaft_diameter' => null,
                'phase_supply' => null,
                'cos_phi' => null,
                'efficiency' => null,
                'ip_rating' => null,
                'insulation_class' => null,
                'duty' => null,
                'connection_type' => null,
                'nipple_grease' => null,
                'greasing_type' => null,
                'greasing_qty_de' => null,
                'greasing_qty_nde' => null,
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,

            ])
            ->assertSeeText('The motor successfully updated.');
    }

    public function testUpdateMotorMaterialNumberInvalidType()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '1O013364',
                'unique_id' => '2008',
                'qr_code_link' => 'id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be a number.',
            ]);
    }

    public function testUpdateMotorMaterialNumberInvalidLengthMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '1234',
                'unique_id' => '2008',
                'qr_code_link' => 'id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be 8 digits.',
            ]);
    }

    public function testUpdateMotorMaterialNumberInvalidLengthMax()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '123456789',
                'unique_id' => '2008',
                'qr_code_link' => 'id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be 8 digits.',
            ]);
    }

    public function testUpdateMotorUniqueIdNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '123456789',
                'unique_id' => null,
                'qr_code_link' => 'id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'unique_id' => 'The unique id field is required.',
            ]);
    }

    public function testUpdateMotorUniqueIdInvalidType()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '123456789',
                'unique_id' => '1O2',
                'qr_code_link' => 'id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'unique_id' => 'The unique id field must be a number.',
            ]);
    }

    public function testUpdateMotorUniqueIdUnregistered()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '123456789',
                'unique_id' => '112',
                'qr_code_link' => 'id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'unique_id' => 'The selected unique id is invalid.',
            ]);
    }

    // QR CODE LINK
    public function testUpdateMotorQrCodeLinkNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '123456789',
                'unique_id' => '2008',
                'qr_code_link' => null,
            ])
            ->assertSessionHasErrors([
                'qr_code_link' => 'The qr code link field is required.',
            ]);
    }

    public function testUpdateMotorQrCodeLinkUnregistered()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '123456789',
                'unique_id' => '2008',
                'qr_code_link' => 'id=Fajar-MotorList2001',
            ])
            ->assertSessionHasErrors([
                'qr_code_link' => 'The selected qr code link is invalid.',
            ]);
    }

    public function testUpdateMotorQrCodeLinkNotSameAsUniqueId()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '123456789',
                'unique_id' => '2008',
                'qr_code_link' => 'id=Fajar-MotorList208',
            ])
            ->assertSessionHasErrors([
                'qr_code_link' => 'The selected qr code link is invalid.',
                'qr_code_link' => 'The qr code link id must be same as unique id.',
            ]);
    }

    // REGISTER
    public function testRegisterMotorGuest()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        $this->post('/motor-register', [])
            ->assertRedirect('/login');
    }

    public function testRegisterMotorEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia'
        ]);

        $this->followingRedirects()
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-MotorList123',
            ])
            ->assertSeeText('[403] Forbidden')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testRegisterMotorAdminSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->followingRedirects()
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-MotorList123',
                'motor_detail' => null,
                'manufacturer' => null,
                'serial_number' => null,
                'type' => null,
                'power_rate' => null,
                'power_unit' => null,
                'voltage' => null,
                'electrical_current' => null,
                'current_nominal' => null,
                'frequency' => null,
                'pole' => null,
                'rpm' => null,
                'bearing_de' => null,
                'bearing_nde' => null,
                'frame_type' => null,
                'shaft_diameter' => null,
                'phase_supply' => null,
                'cos_phi' => null,
                'efficiency' => null,
                'ip_rating' => null,
                'insulation_class' => null,
                'duty' => null,
                'connection_type' => null,
                'nipple_grease' => null,
                'greasing_type' => null,
                'greasing_qty_de' => null,
                'greasing_qty_nde' => null,
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSeeText('The motor successfully registered.');
    }

    // PROHIBITED FUNCLOC AND SORTFIELD
    public function testRegisterMotorAuthorizedProhibitedFunclocAvailable()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->get('/motor-registration');

        $this->followingRedirects()
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Available',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => null,
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-MotorList123',
                'motor_detail' => null,
                'manufacturer' => null,
                'serial_number' => null,
                'type' => null,
                'power_rate' => null,
                'power_unit' => null,
                'voltage' => null,
                'electrical_current' => null,
                'current_nominal' => null,
                'frequency' => null,
                'pole' => null,
                'rpm' => null,
                'bearing_de' => null,
                'bearing_nde' => null,
                'frame_type' => null,
                'shaft_diameter' => null,
                'phase_supply' => null,
                'cos_phi' => null,
                'efficiency' => null,
                'ip_rating' => null,
                'insulation_class' => null,
                'duty' => null,
                'connection_type' => null,
                'nipple_grease' => null,
                'greasing_type' => null,
                'greasing_qty_de' => null,
                'greasing_qty_nde' => null,
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSeeText('The funcloc field is prohibited when status is Available.');
    }

    public function testRegisterMotorAuthorizedProhibitedSortFieldAvailable()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->followingRedirects()
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => 'C.06/PM3',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-MotorList123',
                'motor_detail' => null,
                'manufacturer' => null,
                'serial_number' => null,
                'type' => null,
                'power_rate' => null,
                'power_unit' => null,
                'voltage' => null,
                'electrical_current' => null,
                'current_nominal' => null,
                'frequency' => null,
                'pole' => null,
                'rpm' => null,
                'bearing_de' => null,
                'bearing_nde' => null,
                'frame_type' => null,
                'shaft_diameter' => null,
                'phase_supply' => null,
                'cos_phi' => null,
                'efficiency' => null,
                'ip_rating' => null,
                'insulation_class' => null,
                'duty' => null,
                'connection_type' => null,
                'nipple_grease' => null,
                'greasing_type' => null,
                'greasing_qty_de' => null,
                'greasing_qty_nde' => null,
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSeeText('The sort field field is prohibited when status is Available.');
    }

    // PROHIBITED REPAIRED STATUS
    public function testRegisterMotorAuthorizedProhibitedFunclocRepaired()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->followingRedirects()
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Repaired',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => null,
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-MotorList123',
                'motor_detail' => null,
                'manufacturer' => null,
                'serial_number' => null,
                'type' => null,
                'power_rate' => null,
                'power_unit' => null,
                'voltage' => null,
                'electrical_current' => null,
                'current_nominal' => null,
                'frequency' => null,
                'pole' => null,
                'rpm' => null,
                'bearing_de' => null,
                'bearing_nde' => null,
                'frame_type' => null,
                'shaft_diameter' => null,
                'phase_supply' => null,
                'cos_phi' => null,
                'efficiency' => null,
                'ip_rating' => null,
                'insulation_class' => null,
                'duty' => null,
                'connection_type' => null,
                'nipple_grease' => null,
                'greasing_type' => null,
                'greasing_qty_de' => null,
                'greasing_qty_nde' => null,
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSeeText('The funcloc field is prohibited when status is Repaired.');
    }

    public function testRegisterMotorAuthorizedProhibitedSortFieldRepaired()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->followingRedirects()
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Repaired',
                'funcloc' => null,
                'sort_field' => 'C.06/PM3',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-MotorList123',
                'motor_detail' => null,
                'manufacturer' => null,
                'serial_number' => null,
                'type' => null,
                'power_rate' => null,
                'power_unit' => null,
                'voltage' => null,
                'electrical_current' => null,
                'current_nominal' => null,
                'frequency' => null,
                'pole' => null,
                'rpm' => null,
                'bearing_de' => null,
                'bearing_nde' => null,
                'frame_type' => null,
                'shaft_diameter' => null,
                'phase_supply' => null,
                'cos_phi' => null,
                'efficiency' => null,
                'ip_rating' => null,
                'insulation_class' => null,
                'duty' => null,
                'connection_type' => null,
                'nipple_grease' => null,
                'greasing_type' => null,
                'greasing_qty_de' => null,
                'greasing_qty_nde' => null,
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSeeText('The sort field field is prohibited when status is Repaired.');
    }

    public function testRegisterMotorAuthorizedInvalidIdNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => null,
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
            'motor_detail' => null,
            'manufacturer' => null,
            'serial_number' => null,
            'type' => null,
            'power_rate' => null,
            'power_unit' => null,
            'voltage' => null,
            'electrical_current' => null,
            'current_nominal' => null,
            'frequency' => null,
            'pole' => null,
            'rpm' => null,
            'bearing_de' => null,
            'bearing_nde' => null,
            'frame_type' => null,
            'shaft_diameter' => null,
            'phase_supply' => null,
            'cos_phi' => null,
            'efficiency' => null,
            'ip_rating' => null,
            'insulation_class' => null,
            'duty' => null,
            'connection_type' => null,
            'nipple_grease' => null,
            'greasing_type' => null,
            'greasing_qty_de' => null,
            'greasing_qty_nde' => null,
            'length' => null,
            'width' => null,
            'height' => null,
            'weight' => null,
            'cooling_fan' => null,
            'mounting' => null,
        ])
            ->assertSessionHasErrors([
                'id' => 'The id field is required.'
            ]);
    }

    public function testRegisterMotorAuthorizedInvalidIdLengthMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
            'motor_detail' => null,
            'manufacturer' => null,
            'serial_number' => null,
            'type' => null,
            'power_rate' => null,
            'power_unit' => null,
            'voltage' => null,
            'electrical_current' => null,
            'current_nominal' => null,
            'frequency' => null,
            'pole' => null,
            'rpm' => null,
            'bearing_de' => null,
            'bearing_nde' => null,
            'frame_type' => null,
            'shaft_diameter' => null,
            'phase_supply' => null,
            'cos_phi' => null,
            'efficiency' => null,
            'ip_rating' => null,
            'insulation_class' => null,
            'duty' => null,
            'connection_type' => null,
            'nipple_grease' => null,
            'greasing_type' => null,
            'greasing_qty_de' => null,
            'greasing_qty_nde' => null,
            'length' => null,
            'width' => null,
            'height' => null,
            'weight' => null,
            'cooling_fan' => null,
            'mounting' => null,
        ])
            ->assertSessionHasErrors([
                'id' => 'The id field must be 9 characters.'
            ]);
    }

    public function testRegisterMotorAuthorizedIdDuplicate()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000124',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
            'motor_detail' => null,
            'manufacturer' => null,
            'serial_number' => null,
            'type' => null,
            'power_rate' => null,
            'power_unit' => null,
            'voltage' => null,
            'electrical_current' => null,
            'current_nominal' => null,
            'frequency' => null,
            'pole' => null,
            'rpm' => null,
            'bearing_de' => null,
            'bearing_nde' => null,
            'frame_type' => null,
            'shaft_diameter' => null,
            'phase_supply' => null,
            'cos_phi' => null,
            'efficiency' => null,
            'ip_rating' => null,
            'insulation_class' => null,
            'duty' => null,
            'connection_type' => null,
            'nipple_grease' => null,
            'greasing_type' => null,
            'greasing_qty_de' => null,
            'greasing_qty_nde' => null,
            'length' => null,
            'width' => null,
            'height' => null,
            'weight' => null,
            'cooling_fan' => null,
            'mounting' => null,
        ])
            ->assertSessionHasErrors([
                'id' => 'The selected id is invalid.'
            ]);
    }

    public function testRegisterMotorAuthorizedIdInvalidPrefix()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'MJO000124',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
            'motor_detail' => null,
            'manufacturer' => null,
            'serial_number' => null,
            'type' => null,
            'power_rate' => null,
            'power_unit' => null,
            'voltage' => null,
            'electrical_current' => null,
            'current_nominal' => null,
            'frequency' => null,
            'pole' => null,
            'rpm' => null,
            'bearing_de' => null,
            'bearing_nde' => null,
            'frame_type' => null,
            'shaft_diameter' => null,
            'phase_supply' => null,
            'cos_phi' => null,
            'efficiency' => null,
            'ip_rating' => null,
            'insulation_class' => null,
            'duty' => null,
            'connection_type' => null,
            'nipple_grease' => null,
            'greasing_type' => null,
            'greasing_qty_de' => null,
            'greasing_qty_nde' => null,
            'length' => null,
            'width' => null,
            'height' => null,
            'weight' => null,
            'cooling_fan' => null,
            'mounting' => null,
        ])
            ->assertSessionHasErrors([
                'id' => 'The id field must start with one of the following: EMO, MGM, MGB, MDO, MFB.'
            ]);
    }

    // STATUS
    public function testRegisterMotorAuthorizedStatusNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => null,
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'status' => 'The status field is required.'
            ]);
    }

    public function testRegisterMotorAuthorizedFunclocNullSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->followingRedirects()
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-MotorList123',
                'motor_detail' => null,
                'manufacturer' => null,
                'serial_number' => null,
                'type' => null,
                'power_rate' => null,
                'power_unit' => null,
                'voltage' => null,
                'electrical_current' => null,
                'current_nominal' => null,
                'frequency' => null,
                'pole' => null,
                'rpm' => null,
                'bearing_de' => null,
                'bearing_nde' => null,
                'frame_type' => null,
                'shaft_diameter' => null,
                'phase_supply' => null,
                'cos_phi' => null,
                'efficiency' => null,
                'ip_rating' => null,
                'insulation_class' => null,
                'duty' => null,
                'connection_type' => null,
                'nipple_grease' => null,
                'greasing_type' => null,
                'greasing_qty_de' => null,
                'greasing_qty_nde' => null,
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSeeText('The motor successfully registered.');
    }

    public function testRegisterMotorAuthorizedFunclocNullFailed()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => null,
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
            'motor_detail' => null,
            'manufacturer' => null,
            'serial_number' => null,
            'type' => null,
            'power_rate' => null,
            'power_unit' => null,
            'voltage' => null,
            'electrical_current' => null,
            'current_nominal' => null,
            'frequency' => null,
            'pole' => null,
            'rpm' => null,
            'bearing_de' => null,
            'bearing_nde' => null,
            'frame_type' => null,
            'shaft_diameter' => null,
            'phase_supply' => null,
            'cos_phi' => null,
            'efficiency' => null,
            'ip_rating' => null,
            'insulation_class' => null,
            'duty' => null,
            'connection_type' => null,
            'nipple_grease' => null,
            'greasing_type' => null,
            'greasing_qty_de' => null,
            'greasing_qty_nde' => null,
            'length' => null,
            'width' => null,
            'height' => null,
            'weight' => null,
            'cooling_fan' => null,
            'mounting' => null,
        ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field is required when status is Installed.'
            ]);
    }

    public function testRegisterMotorAuthorizedFunclocInvalidPrefix()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => 'FP-02-PM3-OCC',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field must start with one of the following: FP-01.'
            ]);
    }

    public function testRegisterMotorAuthorizedFunclocInvalidFormat()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => 'FP-02-PM3-@OCC',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field must start with one of the following: FP-01.',
                'funcloc' => 'The selected funcloc is invalid.',
            ]);
    }

    public function testRegisterMotorAuthorizedFunclocUnregistered()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'funcloc' => 'The selected funcloc is invalid.'
            ]);
    }

    // SORT FIELD
    public function testRegisterMotorAuthorizedSortfieldNullSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->followingRedirects()
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-MotorList123',
                'motor_detail' => null,
                'manufacturer' => null,
                'serial_number' => null,
                'type' => null,
                'power_rate' => null,
                'power_unit' => null,
                'voltage' => null,
                'electrical_current' => null,
                'current_nominal' => null,
                'frequency' => null,
                'pole' => null,
                'rpm' => null,
                'bearing_de' => null,
                'bearing_nde' => null,
                'frame_type' => null,
                'shaft_diameter' => null,
                'phase_supply' => null,
                'cos_phi' => null,
                'efficiency' => null,
                'ip_rating' => null,
                'insulation_class' => null,
                'duty' => null,
                'connection_type' => null,
                'nipple_grease' => null,
                'greasing_type' => null,
                'greasing_qty_de' => null,
                'greasing_qty_nde' => null,
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSeeText('The motor successfully registered.');
    }

    public function testRegisterMotorAuthorizedSortfieldNullFailed()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => null,
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field is required when status is Installed.'
            ]);
    }

    public function testRegisterMotorAuthorizedSortfieldInvalidLengthMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'AU',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field must be at least 3 characters.'
            ]);
    }

    public function testRegisterMotorAuthorizedSortfieldInvalidLengthMax()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'THIS-SORT-FIELD-IS-TOO-LONG-MORE-THAN-FIFTY-CHARACTER-MAKE-THE-SORTFIELD-IS-INVALID',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field must not be greater than 50 characters.'
            ]);
    }

    // DESCRIPTION
    public function testRegisterMotorAuthorizedDescriptionNullSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->followingRedirects()
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => null,
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-MotorList123',
                'motor_detail' => null,
                'manufacturer' => null,
                'serial_number' => null,
                'type' => null,
                'power_rate' => null,
                'power_unit' => null,
                'voltage' => null,
                'electrical_current' => null,
                'current_nominal' => null,
                'frequency' => null,
                'pole' => null,
                'rpm' => null,
                'bearing_de' => null,
                'bearing_nde' => null,
                'frame_type' => null,
                'shaft_diameter' => null,
                'phase_supply' => null,
                'cos_phi' => null,
                'efficiency' => null,
                'ip_rating' => null,
                'insulation_class' => null,
                'duty' => null,
                'connection_type' => null,
                'nipple_grease' => null,
                'greasing_type' => null,
                'greasing_qty_de' => null,
                'greasing_qty_nde' => null,
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSeeText('The motor successfully registered.');
    }

    public function testRegisterMotorAuthorizedDescriptionInvalidLengthMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'description' => 'The description field must be at least 3 characters.'
            ]);
    }

    public function testRegisterMotorAuthorizedDescriptionInvalidLengthMax()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'THIS-DESCRIPTION-IS-TOO-LONG-MORE-THAN-FIFTY-CHARACTER-MAKE-THE-SORTFIELD-IS-INVALID',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'description' => 'The description field must not be greater than 50 characters.'
            ]);
    }

    // MATERIAL NUMBER
    public function testRegisterMotorAuthorizedMaterialNumberNullSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->followingRedirects()
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => null,
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-MotorList123',
                'motor_detail' => 'EMO000123',
                'manufacturer' => null,
                'serial_number' => null,
                'type' => null,
                'power_rate' => null,
                'power_unit' => null,
                'voltage' => null,
                'electrical_current' => null,
                'current_nominal' => null,
                'frequency' => null,
                'pole' => null,
                'rpm' => null,
                'bearing_de' => null,
                'bearing_nde' => null,
                'frame_type' => null,
                'shaft_diameter' => null,
                'phase_supply' => null,
                'cos_phi' => null,
                'efficiency' => null,
                'ip_rating' => null,
                'insulation_class' => null,
                'duty' => null,
                'connection_type' => null,
                'nipple_grease' => null,
                'greasing_type' => null,
                'greasing_qty_de' => null,
                'greasing_qty_nde' => null,
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSeeText('The motor successfully registered.');
    }

    public function testRegisterMotorAuthorizedMaterialNumberInvalidLengthMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '1001219',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be 8 digits.'
            ]);
    }

    public function testRegisterMotorAuthorizedMaterialNumberInvalidFormat()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '1001O110',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be a number.'
            ]);
    }

    // UNIQUE ID
    public function testRegisterMotorAuthorizedUniqueIdNullFailed()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => null,
            'qr_code_link' => 'id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'unique_id' => 'The unique id field is required.'
            ]);
    }

    public function testRegisterMotorAuthorizedUniqueIdInvalidFormat()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '999a9',
            'qr_code_link' => 'id=Fajar-MotorList9999',
        ])
            ->assertSessionHasErrors([
                'unique_id' => 'The unique id field must be a number.'
            ]);
    }

    public function testRegisterMotorAuthorizedUniqueIdDuplicate()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000124',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '9999',
            'qr_code_link' => 'id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'id' => 'The selected id is invalid.'
            ]);
    }

    // QR CODE LINK
    public function testRegisterMotorAuthorizedQrCodeLinkNullFailed()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => null
        ])
            ->assertSessionHasErrors([
                'qr_code_link' => 'The qr code link field is required.'
            ]);
    }

    public function testRegisterMotorAuthorizedQrCodeLinkInvalidPrefix()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'http://www.safesave.info/MIC.php?id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'qr_code_link' => 'The qr code link field must start with one of the following: id=Fajar-MotorList.'
            ]);
    }

    public function testRegisterMotorAuthorizedQrCodeLinkDuplicate()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration');

        $this->post('/motor-register', [
            'id' => 'EMO000123',
            'status' => 'Installed',
            'funcloc' => 'FP-01-PM3-OCC-PU01',
            'sort_field' => 'SP3.SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'id=Fajar-MotorList9999',
        ])
            ->assertSessionHasErrors([
                'qr_code_link' => 'The selected qr code link is invalid.'
            ]);
    }

    // ==========================================
    // =========== INSTALL DISMANTLE ============
    // ==========================================
    public function testMotorGetInstallDismantlePageGuest()
    {
        $this->get('/motor-install-dismantle')
            ->assertRedirectToRoute('login');
    }

    public function testMotorGetInstallDismantlePageEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->get('/motor-install-dismantle')
            ->assertSeeText('[403] Forbidden')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testGetInstallDismantlePageAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/motor-install-dismantle')
            ->assertSeeText('Install dismantle')
            ->assertSeeText('Table')
            ->assertSeeText('Dismantle')
            ->assertSeeText('Dismantled equipment')
            ->assertSeeText('Install')
            ->assertSeeText('Installed equipment');
    }

    // POST
    public function testMotorDoInstallDismantleSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        $dismantle = Motor::query()->find('EMO000426');
        self::assertEquals($dismantle->status, 'Installed');
        self::assertEquals($dismantle->funcloc, 'FP-01-SP3-RJS-T092-P092');
        self::assertEquals($dismantle->sort_field, 'SP3.P.70/M');

        $install = Motor::query()->find('EMO000075');
        self::assertEquals($install->status, 'Available');
        self::assertNull($install->funcloc);
        self::assertNull($install->sort_field);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->post('/motor-install-dismantle', [
                'id_dismantle' => 'EMO000426',
                'id_install' => 'EMO000075',
            ])
            ->assertSeeText('[200] Success')
            ->assertSeeText('The motor was successfully swapped.');

        $dismantled = Motor::query()->find('EMO000426');
        self::assertNotEquals($dismantled->status, 'Installed');
        self::assertNotEquals($dismantled->funcloc, 'FP-01-SP3-RJS-T092-P092');
        self::assertNotEquals($dismantled->sort_field, 'SP3.P.70/M');

        $installed = Motor::query()->find('EMO000075');
        self::assertEquals($installed->status, 'Installed');
        self::assertEquals($installed->funcloc, 'FP-01-SP3-RJS-T092-P092');
        self::assertEquals($installed->sort_field, 'SP3.P.70/M');
    }

    public function testMotorDoInstallDismantleNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->post('/motor-install-dismantle', [
                'id_dismantle' => null,
                'id_install' => null,
            ])
            ->assertSeeText('The id dismantle field is required.');
    }

    public function testMotorDoInstallDismantleNullDismantleField()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->post('/motor-install-dismantle', [
                'id_dismantle' => null,
                'id_install' => 'EMO000075',
            ])
            ->assertSeeText('The id dismantle field is required.');
    }

    public function testMotorDoInstallDismantleNullInstallField()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->post('/motor-install-dismantle', [
                'id_dismantle' => 'EMO000426',
                'id_install' => null,
            ])
            ->assertSeeText('The id install field is required.');
    }

    public function testMotorDoInstallDismantleDismantleInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->post('/motor-install-dismantle', [
                'id_dismantle' => 'EMO000000',
                'id_install' => 'EMO000075',
            ])
            ->assertSeeText('The selected id dismantle is invalid.');
    }

    public function testMotorDoInstallDismantleInstallInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->post('/motor-install-dismantle', [
                'id_dismantle' => 'EMO000426',
                'id_install' => 'EMO000000',
            ])
            ->assertSeeText('The selected id install is invalid.');
    }

    public function testMotorDoInstallDismantleInstallDismantleNotDifferent()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->post('/motor-install-dismantle', [
                'id_dismantle' => 'EMO000426',
                'id_install' => 'EMO000426',
            ])
            ->assertSeeText('The id dismantle field and id install must be different.');
    }

    public function testMotorDoInstallDismantleInstallInvalidSize()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->post('/motor-install-dismantle', [
                'id_dismantle' => 'EMO00046',
                'id_install' => 'EMO000426',
            ])
            ->assertSeeText('The id dismantle field must be 9 characters.');
    }

    public function testMotorDoInstallDismantleDismantleInvalidSize()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->post('/motor-install-dismantle', [
                'id_dismantle' => 'EMO000426',
                'id_install' => 'EMO00057',
            ])
            ->assertSeeText('The id install field must be 9 characters.');
    }

    // GET EQUIPMENT MOTOR AJAX
    // DISMANTLE
    public function testMotorGetEquipmentDismantleValid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this

            ->get('/motor-install-dismantle');

        $response = $this->post('/equipment-motor', [
            'equipment' => 'EMO000426',
            'status' => 'Installed',
        ]);

        self::assertNotNull($response);
        $motor = $response->baseResponse->original;
        self::assertEquals($motor->funcloc, 'FP-01-SP3-RJS-T092-P092');
        self::assertEquals($motor->material_number, '10010668');
        self::assertEquals($motor->unique_id, '1804');
    }

    public function testMotorGetEquipmentDismantleInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this

            ->get('/motor-install-dismantle');

        $response = $this->post('/equipment-motor', [
            'equipment' => 'EMO000000',
            'status' => 'Installed',
        ]);

        self::assertNotNull($response);
        $motor = $response->baseResponse->original;
        self::assertEmpty($motor);
    }

    public function testMotorGetEquipmentDismantleRepairedMotor()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this

            ->get('/motor-install-dismantle');

        $response = $this->post('/equipment-motor', [
            'equipment' => 'EMO000105', // repaired
            'status' => 'Installed',
        ]);

        self::assertNotNull($response);
        $motor = $response->baseResponse->original;
        self::assertEmpty($motor);
    }

    // INSTALL
    public function testMotorGetEquipmentInstallValid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this

            ->get('/motor-install-dismantle');

        $response = $this->post('/equipment-motor', [
            'equipment' => 'EMO000075',
            'status' => 'Available',
        ]);

        self::assertNotNull($response);
        $motor = $response->baseResponse->original;
        self::assertEquals($motor->status, 'Available');
        self::assertNull($motor->funcloc);
        self::assertNull($motor->sort_field);
        self::assertEquals($motor->material_number, '10011051');
        self::assertEquals($motor->unique_id, '273');
    }

    public function testMotorGetEquipmentInstallInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this

            ->get('/motor-install-dismantle');

        $response = $this->post('/equipment-motor', [
            'equipment' => 'EMO000000',
            'status' => 'Available',
        ]);

        self::assertNotNull($response);
        $motor = $response->baseResponse->original;
        self::assertEmpty($motor);
    }

    public function testMotorGetEquipmentInstallRepairedMotor()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this

            ->get('/motor-install-dismantle');

        $response = $this->post('/equipment-motor', [
            'equipment' => 'EMO000113', // repaired
            'status' => 'Installed',
        ]);

        self::assertNotNull($response);
        $motor = $response->baseResponse->original;
        self::assertEmpty($motor);
    }
}
