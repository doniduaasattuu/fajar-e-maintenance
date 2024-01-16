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
            ->assertDontSeeText('Available')
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
            ->assertDontSeeText('Available')
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
}
