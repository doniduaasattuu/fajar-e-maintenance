<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->get('/motors')
            ->assertSeeText('Table motor')
            ->assertSeeText('New motor')
            ->assertSeeText('Filter')
            ->assertSeeText('The total registered motor is 22 records.')
            ->assertSeeText('Trend')
            ->assertSeeText('Edit')
            ->assertSeeText('MGM000481');
    }

    public function testGetMotorsAuthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/motors')
            ->assertSeeText('Table motor')
            ->assertSeeText('New motor')
            ->assertSeeText('Filter')
            ->assertSeeText('The total registered motor is 22 records.')
            ->assertSeeText('Trend')
            ->assertSeeText('Edit')
            ->assertSeeText('MGM000481');
    }

    public function testGetMotorsAuthorizedEmptyDb()
    {
        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/motors')
            ->assertSeeText('Table motor')
            ->assertSeeText('New motor')
            ->assertSeeText('Filter')
            ->assertSeeText('The total registered motor is 0 records.')
            ->assertSeeText('Trend')
            ->assertSeeText('Edit')
            ->assertDontSeeText('MGM000481');
    }

    public function testGetEditMotorGuest()
    {
        $this->get('/motor-edit/EMO000008')
            ->assertRedirect('/login');
    }

    public function testGetEditMotorEmployee()
    {
        $this->seed(DatabaseSeeder::class);

        $this->followingRedirects()
            ->withSession([
                'nik' => '55000153',
                'user' => 'Jamal Mirdad'
            ])
            ->get('/motor-edit/EMO000008')
            ->assertSeeText('[403] You are not authorized!')
            ->assertSeeText('You are not allowed to perform this operation!.');
    }

    public function testGetEditMotorUregisteredAuthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/motor-edit/EMO000008')
            ->assertSeeText('Unique id')
            ->assertSee('4592');

        $this->followingRedirects()
            ->withSession([
                'nik' => '55000154',
                'user' => 'Doni Darmawan'
            ])
            ->get('/motor-edit/EMO000001')
            ->assertSeeText('[404] Not found.')
            ->assertSeeText('The motor EMO000001 is unregistered.');
    }

    public function testGetEditMotorAuthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
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
            ->assertSeeText('Update');
    }

    public function testGetMotorDetailsGuest()
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/motor-details/EMO000105')
            ->assertRedirect('/login');
    }

    public function testGetMotorDetailsEmployee()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->get('/motor-details/EMO000105')
            ->assertSeeText('Motor details')
            ->assertSeeText('Status')
            ->assertDontSeeText('Installed')
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
            ->assertSee('https://www.safesave.info/MIC.php?id=Fajar-MotorList56')
            ->assertSeeText('Created at')
            ->assertSeeText('Updated at')
            ->assertSee('disabled');
    }

    public function testGetMotorDetailsAuthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/motor-details/EMO000105')
            ->assertSeeText('Motor details')
            ->assertSeeText('Status')
            ->assertDontSeeText('Installed')
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
            ->assertSee('https://www.safesave.info/MIC.php?id=Fajar-MotorList56')
            ->assertSeeText('Created at')
            ->assertSeeText('Updated at')
            ->assertSee('disabled');
    }

    public function testGetMotorDetailsUregisteredAuthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/motor-edit/EMO000008')
            ->assertSeeText('Unique id')
            ->assertSee('4592');

        $this->followingRedirects()
            ->withSession([
                'nik' => '55000154',
                'user' => 'Doni Darmawan'
            ])
            ->get('/motor-edit/EMO000001')
            ->assertSeeText('[404] Not found.')
            ->assertSeeText('The motor EMO000001 is unregistered.');
    }

    // UPDATE
    public function testUpdateMotorGuest()
    {
        $this->post('/motor-update', [
            'status' => 'Installed',
            'funcloc' => null,
            'sor_field' => null,
        ])
            ->assertRedirect('/login');
    }

    public function testUpdateMotorUnregistered()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/motor-edit/EMO000105');

        $this
            ->post('/motor-update', [
                'id' => 'EMO000000',
                'status' => 'Installed',
                'funcloc' => null,
                'sor_field' => null,
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList56',
            ])
            ->assertSessionHasErrors([
                'id' => 'The selected id is invalid.',
            ]);
    }

    public function testUpdateMotorInvalidIdLength()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/motor-edit/EMO000105');

        $this
            ->post('/motor-update', [
                'id' => 'EMO00105',
                'status' => 'Available',
                'funcloc' => null,
                'sor_field' => null,
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList56',
            ])
            ->assertSessionHasErrors([
                'id' => 'The id field must be 9 characters.',
            ]);
    }

    public function testUpdateMotorInstalledFunclocAndSortfieldNull()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/motor-edit/EMO000105');

        $this
            ->post('/motor-update', [
                'id' => 'EMO000105',
                'status' => 'Installed',
                'funcloc' => null,
                'sor_field' => null,
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList56',
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
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/motor-edit/EMO000105');

        $this->followingRedirects()
            ->post('/motor-update', [
                'id' => 'EMO000105',
                'status' => 'Repaired',
                'funcloc' => null,
                'sor_field' => null,
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList56',
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
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/motor-edit/EMO000105');

        $this->followingRedirects()
            ->post('/motor-update', [
                'id' => 'EMO000105',
                'status' => 'Available',
                'funcloc' => null,
                'sor_field' => null,
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList56',
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
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/motor-edit/EMO000105');

        $this
            ->post('/motor-update', [
                'id' => 'EMO000105',
                'status' => 'Installed',
                'funcloc' => 'SP3-OCC-PU02',
                'sor_field' => 'SP3.SP-04/M',
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList56',
            ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field must start with one of the following: FP-01.',
            ]);
    }

    public function testUpdateMotorFunclocInvalidLengthMin()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/motor-edit/EMO000105');

        $this
            ->post('/motor-update', [
                'id' => 'EMO000105',
                'status' => 'Installed',
                'funcloc' => 'FP-01-SP',
                'sor_field' => 'SP3.SP-04/M',
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList56',
            ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field must be at least 9 characters.',
            ]);
    }

    public function testUpdateMotorFunclocInvalidLengthMax()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/motor-edit/EMO000105');

        $this
            ->post('/motor-update', [
                'id' => 'EMO000105',
                'status' => 'Installed',
                'funcloc' => 'FP-01-SP3-INVALID-LENGTH-MAX-MORE-THAN-FIFTY-CHARACTER-CANNOT-UPDATE-AN-MOTOR-STATUS',
                'sor_field' => 'SP3.SP-04/M',
                'description' => 'AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3',
                'material_number' => '10010923',
                'unique_id' => '56',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList56',
            ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field must not be greater than 50 characters.',
            ]);
    }

    public function testUpdateMotorSortfieldNull()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sor_field' => null,
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => null,
                'unique_id' => '2008',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field is required when status is Installed.',
            ]);
    }

    public function testUpdateMotorSortfieldInvalidLengthMin()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'Y',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => null,
                'unique_id' => '2008',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field must be at least 3 characters.',
            ]);
    }

    public function testUpdateMotorSortfieldInvalidLengthMax()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'SORT-FIELD-INVALID-LENGTH-MAX-MORE-THAN-FIFTY-CHARACTER-CANNOT-UPDATE-AN-MOTOR-STATUS',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => null,
                'unique_id' => '2008',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field must not be greater than 50 characters.',
            ]);
    }

    public function testUpdateMotorDescriptionNull()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
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
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList2008',
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
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC',
                'material_number' => null,
                'unique_id' => '2008',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'description' => 'The description field must be at least 3 characters.',
            ]);
    }

    public function testUpdateMotorDescriptionInvalidLengthMax()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3,INVALID-LENGTH-MAX-MORE-THAN-FIFTY-CHARACTER-CANNOT-UPDATE-AN-MOTOR-STATUS',
                'material_number' => null,
                'unique_id' => '2008',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'description' => 'The description field must not be greater than 50 characters.',
            ]);
    }

    public function testUpdateMotorMaterialNumberNull()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/motor-edit/EMO001056');

        $this->followingRedirects()
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => null,
                'unique_id' => '2008',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList2008',
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
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '1O013364',
                'unique_id' => '2008',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be a number.',
            ]);
    }

    public function testUpdateMotorMaterialNumberInvalidLengthMin()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '1234',
                'unique_id' => '2008',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be 8 digits.',
            ]);
    }

    public function testUpdateMotorMaterialNumberInvalidLengthMax()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '123456789',
                'unique_id' => '2008',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be 8 digits.',
            ]);
    }

    public function testUpdateMotorUniqueIdNull()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '123456789',
                'unique_id' => null,
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'unique_id' => 'The unique id field is required.',
            ]);
    }

    public function testUpdateMotorUniqueIdInvalidType()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '123456789',
                'unique_id' => '1O2',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'unique_id' => 'The unique id field must be a number.',
            ]);
    }

    public function testUpdateMotorUniqueIdUnregistered()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '123456789',
                'unique_id' => '112',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList2008',
            ])
            ->assertSessionHasErrors([
                'unique_id' => 'The selected unique id is invalid.',
            ]);
    }

    public function testUpdateMotorQrCodeLinkNull()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/motor-edit/EMO001056');

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
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/motor-edit/EMO001056');

        $this
            ->post('/motor-update', [
                'id' => 'EMO001056',
                'status' => 'Installed',
                'funcloc' => 'FP-01-CH3-ALM-T089-P085',
                'sort_field' => 'CH3.C06/M',
                'description' => 'AC MOTOR;380V,50Hz,3kW,4P,100L,B3',
                'material_number' => '123456789',
                'unique_id' => '2008',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList2001',
            ])
            ->assertSessionHasErrors([
                'qr_code_link' => 'The selected qr code link is invalid.',
            ]);
    }

    // REGISTER
    public function testRegisterMotorGuest()
    {
        $this->seed(DatabaseSeeder::class);

        $this->post('/motor-register', [])
            ->assertRedirect('/login');
    }

    public function testRegisterMotorEmployee()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->followingRedirects()
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
            ])
            ->assertSeeText('[403] You are not authorized!')
            ->assertSeeText('You are not allowed to perform this operation!.');
    }

    public function testRegisterMotorAuthorizedSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
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

    public function testRegisterMotorAuthorizedInvalidIdNull()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
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
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
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

    public function testRegisterMotorAuthorizedDuplicate()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
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

    public function testRegisterMotorAuthorizedInvalidPrefix()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
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
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'status' => 'The status field is required.'
            ]);
    }

    public function testRegisterMotorAuthorizedFunclocNullSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
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
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
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
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field must start with one of the following: FP-01.'
            ]);
    }

    public function testRegisterMotorAuthorizedFunclocInvalidFormat()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field must only contain letters, numbers, dashes, and underscores.'
            ]);
    }

    public function testRegisterMotorAuthorizedFunclocUnregistered()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'funcloc' => 'The selected funcloc is invalid.'
            ]);
    }

    // SORT FIELD
    public function testRegisterMotorAuthorizedSortfieldNullSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => null,
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
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
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field is required when status is Installed.'
            ]);
    }

    public function testRegisterMotorAuthorizedSortfieldInvalidLengthMin()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field must be at least 3 characters.'
            ]);
    }

    public function testRegisterMotorAuthorizedSortfieldInvalidLengthMax()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field must not be greater than 50 characters.'
            ]);
    }

    public function testRegisterMotorAuthorizedSortfieldInvalidFormat()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'sort_field' => 'SP3.@SP-03/M',
            'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
            'material_number' => '10012345',
            'unique_id' => '123',
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field format is invalid.'
            ]);
    }

    // DESCRIPTION
    public function testRegisterMotorAuthorizedDescriptionNullSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => null,
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
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
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'description' => 'The description field must be at least 3 characters.'
            ]);
    }

    public function testRegisterMotorAuthorizedDescriptionInvalidLengthMax()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'description' => 'The description field must not be greater than 50 characters.'
            ]);
    }

    // MATERIAL NUMBER
    public function testRegisterMotorAuthorizedMaterialNumberNullSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => null,
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
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
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be 8 digits.'
            ]);
    }

    public function testRegisterMotorAuthorizedMaterialNumberInvalidFormat()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be a number.'
            ]);
    }

    // UNIQUE ID
    public function testRegisterMotorAuthorizedUniqueIdNullFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'unique_id' => 'The unique id field is required.'
            ]);
    }

    public function testRegisterMotorAuthorizedUniqueIdInvalidFormat()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList9999',
        ])
            ->assertSessionHasErrors([
                'unique_id' => 'The unique id field must be a number.'
            ]);
    }

    public function testRegisterMotorAuthorizedUniqueIdDuplicate()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',
        ])
            ->assertSessionHasErrors([
                'id' => 'The selected id is invalid.'
            ]);
    }

    // QR CODE LINK
    public function testRegisterMotorAuthorizedQrCodeLinkNullFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
                'qr_code_link' => 'The qr code link field must start with one of the following: https://www.safesave.info/MIC.php?id=Fajar-MotorList.'
            ]);
    }


    public function testRegisterMotorAuthorizedQrCodeLinkInvalidFormat()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
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
            'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList9999',
        ])
            ->assertSessionHasErrors([
                'qr_code_link' => 'The selected qr code link is invalid.'
            ]);
    }
}
