<?php

namespace Tests\Feature;

use App\Models\Trafo;
use App\Models\TrafoDetails;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TrafoDetailsSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class TrafoControllerTest extends TestCase
{
    public function testGetTrafosGuest()
    {
        $this->get('/trafos')
            ->assertRedirectToRoute('login');
    }

    public function testGetTrafosEmployee()
    {
        $this->seed([FunclocSeeder::class]);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->get('/trafos')
            ->assertSeeText('Table trafo')
            ->assertSeeText('New trafo')
            ->assertSeeText('Filter')
            ->assertSeeText('The total registered trafo is 11 records.')
            ->assertSeeText('Trend')
            ->assertSeeText('Edit')
            ->assertSeeText('ETF001234');
    }

    public function testGetTrafosAuthorized()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafos')
            ->assertSeeText('Table trafo')
            ->assertSeeText('New trafo')
            ->assertSeeText('Filter')
            ->assertSeeText('The total registered trafo is 12 records.')
            ->assertSeeText('Trend')
            ->assertSeeText('Edit')
            ->assertSeeText('ETF001234');
    }

    public function testGetTrafosAuthorizedEmptyDb()
    {
        $this->seed([FunclocSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafos')
            ->assertSeeText('Table trafo')
            ->assertSeeText('New trafo')
            ->assertSeeText('Filter')
            ->assertSeeText('The total registered trafo is 0 records.')
            ->assertSeeText('Trend')
            ->assertSeeText('Edit')
            ->assertDontSeeText('ETF001234');
    }

    public function testGetEditTrafoGuest()
    {
        $this->get('/trafo-edit/ETF000085')
            ->assertRedirect('/login');
    }

    public function testGetEditTrafoEmployee()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->followingRedirects()
            ->withSession([
                'nik' => '55000153',
                'user' => 'Jamal Mirdad'
            ])
            ->get('/trafo-edit/ETF000085')
            ->assertSeeText('[403] You are not authorized!')
            ->assertSeeText('You are not allowed to perform this operation!.');
    }

    public function testGetEditTrafoUregisteredAuthorized()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000085')
            ->assertSeeText('Unique id')
            ->assertSee('TRAFO PLN');

        $this->followingRedirects()
            ->withSession([
                'nik' => '55000154',
                'user' => 'Doni Darmawan'
            ])
            ->get('/trafo-edit/ETF000008')
            ->assertSeeText('[404] Not found.')
            ->assertSeeText('The trafo ETF000008 is unregistered.');
    }

    public function testGetEditTrafoAuthorized()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006')
            ->assertSeeText('Edit trafo')
            ->assertSeeText('Status')
            ->assertSeeText('Installed')
            ->assertSeeText('Repaired')
            ->assertSeeText('Available')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Sort field')
            ->assertSeeText('Description')
            ->assertSee('TR INCHENERATOR#2')
            ->assertSeeText('Material number')
            ->assertSeeText('Unique id')
            ->assertSee('8')
            ->assertSeeText('ETF000006')
            ->assertSeeText('Qr code link')
            ->assertSee('id=Fajar-TrafoList8')
            ->assertSeeText('Created at')
            ->assertDontSeeText('Submit')
            ->assertSeeText('Update');
    }

    public function testGetTrafoDetailsGuest()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->get('/trafo-details/ETF000026')
            ->assertRedirect('/login');
    }

    public function testGetTrafoDetailsEmployee()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->get('/trafo-details/ETF000026')
            ->assertSeeText('Trafo details')
            ->assertSeeText('Status')
            ->assertSee('Installed')
            ->assertSeeText('Funcloc')
            ->assertSee('FP-01-GT2-TRF-PWP2')
            ->assertSeeText('Description')
            ->assertSee('TR AUX GTG #1 lama')
            ->assertSeeText('Material number')
            ->assertSeeText('Unique id')
            ->assertSee('4')
            ->assertSeeText('Qr code link')
            ->assertSee('id=Fajar-TrafoList4')
            ->assertSeeText('Created at')
            ->assertSeeText('Updated at')
            ->assertSee('disabled');
    }

    public function testGetTrafoDetailsAuthorized()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->get('/trafo-details/ETF000026')
            ->assertSeeText('Trafo details')
            ->assertSeeText('Status')
            ->assertSee('Installed')
            ->assertSeeText('Funcloc')
            ->assertSee('FP-01-GT2-TRF-PWP2')
            ->assertSeeText('Description')
            ->assertSee('TR AUX GTG #1 lama')
            ->assertSeeText('Material number')
            ->assertSeeText('Unique id')
            ->assertSee('4')
            ->assertSeeText('Qr code link')
            ->assertSee('id=Fajar-TrafoList4')
            ->assertSeeText('Created at')
            ->assertSeeText('Updated at')
            ->assertSee('disabled');
    }

    public function testGetTrafoDetailsUregisteredAuthorized()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000026')
            ->assertSeeText('Unique id')
            ->assertSee('4');

        $this->followingRedirects()
            ->withSession([
                'nik' => '55000154',
                'user' => 'Doni Darmawan'
            ])
            ->get('/trafo-edit/ETF000001')
            ->assertSeeText('[404] Not found.')
            ->assertSeeText('The trafo ETF000001 is unregistered.');
    }

    // UPDATE
    public function testUpdateTrafoGuest()
    {
        $this->post('/trafo-update', [
            'status' => 'Installed',
            'funcloc' => null,
            'sort_field' => null,
        ])
            ->assertRedirect('/login');
    }

    public function testUpdateTrafoUnregistered()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000001',
                'status' => 'Repaired',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TRAFO;20000V/380V,50Hz,3000kVA',
                'material_number' => '10010923',
                'unique_id' => '11',
                'qr_code_link' => 'id=Fajar-TrafoList11',
            ])
            ->assertSessionHasErrors([
                'id' => 'The selected id is invalid.',
            ]);
    }

    public function testUpdateTrafoInvalidIdLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000105');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF00105',
                'status' => 'Repaired',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TRAFO;20000V/380V,50Hz,3000kVA',
                'material_number' => '10010923',
                'unique_id' => '11',
                'qr_code_link' => 'id=Fajar-TrafoList11',
            ])
            ->assertSessionHasErrors([
                'id' => 'The id field must be 9 characters.',
            ]);
    }

    public function testUpdateTrafoInstalledFunclocAndSortfieldNull()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field is required when status is Installed.',
                'sort_field' => 'The sort field field is required when status is Installed.',
            ]);
    }

    public function testUpdateTrafoRepairedFunclocAndSortfieldNull()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this->followingRedirects()
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Repaired',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSeeText('The trafo successfully updated.');
    }

    public function testUpdateTrafoAvailableFunclocAndSortfieldNull()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this->followingRedirects()
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSeeText('The trafo successfully updated.');
    }

    public function testUpdateTrafoFunclocInvalidPrefix()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000105');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Available',
                'funcloc' => 'FP-02-SP3-OCC-PU02',
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
            ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field must start with one of the following: FP-01.',
            ]);
    }

    public function testUpdateTrafoFunclocInvalidLengthMin()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Available',
                'funcloc' => 'FP-01-SP',
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
            ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field must be at least 9 characters.',
            ]);
    }

    public function testUpdateTrafoFunclocInvalidLengthMax()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Available',
                'funcloc' => 'FP-01-SP3-INVALID-LENGTH-MAX-MORE-THAN-FIFTY-CHARACTER',
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
            ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field must not be greater than 50 characters.',
            ]);
    }

    public function testUpdateTrafoSortfieldNullStatusInstalled()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => 'FP-01-SP3-INVALID-LENGTH-MAX-MORE-THAN-FIFTY-CHARACTER',
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
            ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field is required when status is Installed.',
            ]);
    }

    public function testUpdateTrafoSortfieldInvalidLengthMin()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => 'FP-01-SP3-INVALID-LENGTH-MAX-MORE-THAN-FIFTY-CHARACTER',
                'sort_field' => 'Y',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
            ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field must be at least 3 characters.',
            ]);
    }

    public function testUpdateTrafoSortfieldInvalidLengthMax()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => 'FP-01-SP3-INVALID-LENGTH-MAX-MORE-THAN-FIFTY-CHARACTER',
                'sort_field' => 'SORT-FIELD-INVALID-LENGTH-MAX-MORE-THAN-FIFTY-CHARACTER',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
            ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field must not be greater than 50 characters.',
            ]);
    }

    public function testUpdateTrafoDescriptionNullSuccess()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this->followingRedirects()
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSeeText('The trafo successfully updated.');
    }

    public function testUpdateTrafoDescriptionInvalidLengthMin()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR',
                'material_number' => '10010900',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'description' => 'The description field must be at least 3 characters.',
            ]);
    }

    public function testUpdateTrafoDescriptionInvalidLengthMax()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR INCHENERATOR#2 INVALID-LENGTH-MAX-MORE-THAN-FIFTY-CHARACTER-CANNOT-UPDATE-AN-TRAFO-STATUS',
                'material_number' => '10010900',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'description' => 'The description field must not be greater than 50 characters.',
            ]);
    }

    public function testUpdateTrafoMaterialNumberNull()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this->followingRedirects()
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSeeText('The trafo successfully updated.');
    }

    public function testUpdateTrafoMaterialNumberInvalidType()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '1O013364',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be a number.',
            ]);
    }

    public function testUpdateTrafoMaterialNumberInvalidLengthMin()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '1234',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be 8 digits.',
            ]);
    }

    public function testUpdateTrafoMaterialNumberInvalidLengthMax()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '123456789',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList8',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be 8 digits.',
            ]);
    }

    public function testUpdateTrafoUniqueIdNull()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10012003',
                'unique_id' => null,
                'qr_code_link' => 'id=Fajar-TrafoList8',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'unique_id' => 'The unique id field is required.',
            ]);
    }

    public function testUpdateTrafoUniqueIdInvalidType()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10012003',
                'unique_id' => '1O2',
                'qr_code_link' => 'id=Fajar-TrafoList8',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'unique_id' => 'The unique id field must be a number.',
            ]);
    }

    public function testUpdateTrafoUniqueIdUnregistered()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10012003',
                'unique_id' => '18',
                'qr_code_link' => 'id=Fajar-TrafoList8',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'unique_id' => 'The selected unique id is invalid.',
            ]);
    }

    public function testUpdateTrafoQrCodeLinkNull()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10012003',
                'unique_id' => '8',
                'qr_code_link' => null,
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'qr_code_link' => 'The qr code link field is required.',
            ]);
    }

    public function testUpdateTrafoQrCodeLinkUnregistered()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-edit/ETF000006');

        $this
            ->post('/trafo-update', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10012003',
                'unique_id' => '8',
                'qr_code_link' => 'id=Fajar-TrafoList08',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'qr_code_link' => 'The selected qr code link is invalid.',
            ]);
    }

    // REGISTER
    public function testRegisterTrafoGuest()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->post('/trafo-register', [])
            ->assertRedirect('/login');
    }

    public function testRegisterTrafoEmployee()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000001',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' =>  null,
                'description' => 'TRAFo,3MVA,TRAFINDO,20kV/0.4KV,DELTA/STAR',
                'material_number' => null,
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-TrafoList123',
            ])
            ->assertSeeText('[403] You are not authorized!')
            ->assertSeeText('You are not allowed to perform this operation!.');
    }

    public function testRegisterTrafoAuthorizedSuccess()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->post('/funcloc-register', [
            'id' => 'FP-01-IN1-TRF',
            'description' => 'Trafo IN1'
        ]);

        $this->get('/trafo-registration');

        $this->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000001',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' =>  null,
                'description' => 'TRAFo,3MVA,TRAFINDO,20kV/0.4KV,DELTA/STAR',
                'material_number' => null,
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-TrafoList123',
            ])
            ->assertSeeText('The trafo successfully registered.');
    }

    // PROHIBITED FUNCLOC AND SORTFIELD
    public function testRegisterTrafoAuthorizedProhibitedFunclocAvailable()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->post('/funcloc-register', [
            'id' => 'FP-01-IN1-TRF',
            'description' => 'Trafo IN1'
        ]);

        $this->get('/trafo-registration');

        $this->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000001',
                'status' => 'Available',
                'funcloc' => 'FP-01-IN1',
                'sort_field' =>  null,
                'description' => 'TRAFo,3MVA,TRAFINDO,20kV/0.4KV,DELTA/STAR',
                'material_number' => null,
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-TrafoList123',
            ])
            ->assertSeeText('The funcloc field is prohibited when status is Available.');
    }

    public function testRegisterTrafoAuthorizedProhibitedSortFieldAvailable()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->post('/funcloc-register', [
            'id' => 'FP-01-IN1-TRF',
            'description' => 'Trafo IN1'
        ]);

        $this->get('/trafo-registration');

        $this->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000001',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' =>  'Trafo PLN',
                'description' => 'TRAFo,3MVA,TRAFINDO,20kV/0.4KV,DELTA/STAR',
                'material_number' => null,
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-TrafoList123',
            ])
            ->assertSeeText('The sort field field is prohibited when status is Available.');
    }

    // PROHIBITED REPAIRED STATUS
    public function testRegisterTrafoAuthorizedProhibitedFunclocRepaired()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->post('/funcloc-register', [
            'id' => 'FP-01-IN1-TRF',
            'description' => 'Trafo IN1'
        ]);

        $this->get('/trafo-registration');

        $this->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000001',
                'status' => 'Repaired',
                'funcloc' => 'FP-01-IN1',
                'sort_field' =>  null,
                'description' => 'TRAFo,3MVA,TRAFINDO,20kV/0.4KV,DELTA/STAR',
                'material_number' => null,
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-TrafoList123',
            ])
            ->assertSeeText('The funcloc field is prohibited when status is Repaired.');
    }

    public function testRegisterTrafoAuthorizedProhibitedSortFieldRepaired()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->post('/funcloc-register', [
            'id' => 'FP-01-IN1-TRF',
            'description' => 'Trafo IN1'
        ]);

        $this->get('/trafo-registration');

        $this->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000001',
                'status' => 'Repaired',
                'funcloc' => null,
                'sort_field' =>  'Trafo PLN',
                'description' => 'TRAFo,3MVA,TRAFINDO,20kV/0.4KV,DELTA/STAR',
                'material_number' => null,
                'unique_id' => '123',
                'qr_code_link' => 'id=Fajar-TrafoList123',
            ])
            ->assertSeeText('The sort field field is prohibited when status is Repaired.');
    }

    public function testRegisterTrafoAuthorizedInvalidIdNull()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->post('/funcloc-register', [
            'id' => 'FP-01-IN1-TRF',
            'description' => 'Trafo IN1'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => null,
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'id' => 'The id field is required.'
            ]);
    }

    public function testRegisterTrafoAuthorizedInvalidIdLengthMin()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->post('/funcloc-register', [
            'id' => 'FP-01-IN1-TRF',
            'description' => 'Trafo IN1'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF001',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'id' => 'The id field must be 9 characters.'
            ]);
    }

    public function testRegisterTrafoAuthorizedIdDuplicate()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->post('/funcloc-register', [
            'id' => 'FP-01-IN1-TRF',
            'description' => 'Trafo IN1'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000006',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'id' => 'The selected id is invalid.'
            ]);
    }

    public function testRegisterTrafoAuthorizedIdInvalidPrefix()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->post('/funcloc-register', [
            'id' => 'FP-01-IN1-TRF',
            'description' => 'Trafo IN1'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETG000005',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'id' => 'The id field must start with one of the following: ETF.'
            ]);
    }

    // STATUS
    public function testRegisterTrafoAuthorizedStatusNull()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->post('/funcloc-register', [
            'id' => 'FP-01-IN1-TRF',
            'description' => 'Trafo IN1'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => null,
                'funcloc' => 'FP-01-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR#2',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'status' => 'The status field is required.'
            ]);
    }

    public function testRegisterTrafoAuthorizedFunclocNullSuccess()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->post('/funcloc-register', [
            'id' => 'FP-01-IN1-TRF',
            'description' => 'Trafo IN1'
        ]);

        $this->get('/trafo-registration');

        $this->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSeeText('The trafo successfully registered.');
    }

    public function testRegisterTrafoAuthorizedFunclocNullFailed()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->post('/funcloc-register', [
            'id' => 'FP-01-IN1-TRF',
            'description' => 'Trafo IN1'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Installed',
                'funcloc' => null,
                'sort_field' => 'TR INCHENERATOR',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field is required when status is Installed.'
            ]);
    }

    public function testRegisterTrafoAuthorizedFunclocInvalidPrefix()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->post('/funcloc-register', [
            'id' => 'FP-01-IN1-TRF',
            'description' => 'Trafo IN1'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Installed',
                'funcloc' => 'FP-02-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field must start with one of the following: FP-01.'
            ]);
    }

    public function testRegisterTrafoAuthorizedFunclocInvalidFormat()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->post('/funcloc-register', [
            'id' => 'FP-01-IN1-@TRF',
            'description' => 'Trafo IN1'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Installed',
                'funcloc' => 'FP-02-IN1-TRF',
                'sort_field' => 'TR INCHENERATOR',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'funcloc' => 'The funcloc field must start with one of the following: FP-01.',
                'funcloc' => 'The selected funcloc is invalid.',
            ]);
    }

    public function testRegisterTrafoAuthorizedFunclocUnregistered()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN3-TRF',
                'sort_field' => 'TR INCHENERATOR',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'funcloc' => 'The selected funcloc is invalid.'
            ]);
    }

    // SORT FIELD
    public function testRegisterTrafoAuthorizedSortFieldNullSuccess()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSeeText('The trafo successfully registered.');
    }

    public function testRegisterTrafoAuthorizedSortFieldNullFailed()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1',
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])->assertSessionHasErrors([
                'sort_field' => 'The sort field field is required when status is Installed.'
            ]);
    }

    public function testRegisterTrafoAuthorizedSortFieldInvalidLengthMin()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1',
                'sort_field' => 'AU',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field must be at least 3 characters.'
            ]);
    }

    public function testRegisterTrafoAuthorizedSortFieldInvalidLengthMax()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1',
                'sort_field' => 'THIS-SORT-FIELD-IS-TOO-LONG-MORE-THAN-FIFTY-CHARACTER',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field must not be greater than 50 characters.'
            ]);
    }

    public function testRegisterTrafoAuthorizedSortFieldInvalidFormat()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1',
                'sort_field' => 'SP3.@SP-03/M',
                'description' => 'TR INCHENERATOR#2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'sort_field' => 'The sort field field format is invalid.'
            ]);
    }

    // DESCRIPTION
    public function testRegisterTrafoAuthorizedDescriptionNullSuccess()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1',
                'sort_field' => 'TR INCHI 2',
                'description' => null,
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSeeText('The trafo successfully registered.');
    }

    public function testRegisterTrafoAuthorizedDescriptionInvalidLengthMax()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1',
                'sort_field' => 'TR INCHI 2',
                'description' => 'THIS-DESCRIPTION-IS-TOO-LONG-MORE-THAN-FIFTY-CHARACTER-MAKE-THE-SORTFIELD-IS-INVALID',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'description' => 'The description field must not be greater than 50 characters.'
            ]);
    }

    // MATERIAL NUMBER
    public function testRegisterTrafoAuthorizedMaterialNumberNullSuccess()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1',
                'sort_field' => 'TR INCHI 2',
                'description' => 'TR INCHI 2',
                'material_number' => null,
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSeeText('The trafo successfully registered.');
    }

    public function testRegisterTrafoAuthorizedMaterialNumberInvalidLengthMin()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1',
                'sort_field' => 'TR INCHI 2',
                'description' => 'TR INCHI 2',
                'material_number' => '1001219',
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be 8 digits.'
            ]);
    }

    public function testRegisterTrafoAuthorizedMaterialNumberInvalidFormat()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1',
                'sort_field' => 'TR INCHI 2',
                'description' => 'TR INCHI 2',
                'material_number' => '1001O110',
                'unique_id' => '15',
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be a number.'
            ]);
    }

    // UNIQUE ID
    public function testRegisterTrafoAuthorizedUniqueIdNullFailed()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1',
                'sort_field' => 'TR INCHI 2',
                'description' => 'TR INCHI 2',
                'material_number' => '1001O110',
                'unique_id' => null,
                'qr_code_link' => 'id=Fajar-TrafoList15',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'material_number' => 'The material number field must be a number.'
            ]);
    }

    public function testRegisterTrafoAuthorizedUniqueIdInvalidFormat()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000256',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1',
                'sort_field' => 'TR INCHI 2',
                'description' => 'TR INCHI 2',
                'material_number' => '1001O110',
                'unique_id' => '999a9',
                'qr_code_link' => 'id=Fajar-TrafoList9999',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'unique_id' => 'The unique id field must be a number.'
            ]);
    }

    public function testRegisterTrafoAuthorizedUniqueIdDuplicate()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000085',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1',
                'sort_field' => 'TR INCHI 2',
                'description' => 'TR INCHI 2',
                'material_number' => '1001O110',
                'unique_id' => '99',
                'qr_code_link' => 'id=Fajar-TrafoList99',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'id' => 'The selected id is invalid.'
            ]);
    }

    // QR CODE LINK
    public function testRegisterTrafoAuthorizedQrCodeLinkFailed()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000085',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1',
                'sort_field' => 'TR INCHI 2',
                'description' => 'TR INCHI 2',
                'material_number' => '1001O110',
                'unique_id' => '99',
                'qr_code_link' => null,
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'qr_code_link' => 'The qr code link field is required.'
            ]);
    }

    public function testRegisterTrafoAuthorizedQrCodeLinkInvalidPrefix()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000085',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1',
                'sort_field' => 'TR INCHI 2',
                'description' => 'TR INCHI 2',
                'material_number' => '1001O110',
                'unique_id' => '99',
                'qr_code_link' => 'ID=Fajar-TrafoList99',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'qr_code_link' => 'The qr code link field must start with one of the following: id=Fajar-TrafoList.'
            ]);
    }

    public function testRegisterTrafoAuthorizedQrCodeLinkDuplicate()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000085',
                'status' => 'Installed',
                'funcloc' => 'FP-01-IN1',
                'sort_field' => 'TR INCHI 2',
                'description' => 'TR INCHI 2',
                'material_number' => '1001O110',
                'unique_id' => '99',
                'qr_code_link' => 'id=Fajar-TrafoList9',
                'trafo_detail' => 'ETF000006',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.6',
                'secondary_current' => '4330.1',
                'primary_connection_type' => null,
                'secondary_connection_type' => null,
                'frequency' => '50',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '10338949',
                'vector_group' => 'Dyn5',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'qr_code_link' => 'The selected qr code link is invalid.'
            ]);
    }

    // ==========================================
    // =========== INSTALL DISMANTLE ============
    // ==========================================
    public function testTrafoGetInstallDismantlePageGuest()
    {
        $this->get('/trafo-install-dismantle')
            ->assertRedirectToRoute('login');
    }

    public function testGetInstallDismantlePageEmployee()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->followingRedirects()
            ->get('/trafo-install-dismantle')
            ->assertSeeText('[403] You are not authorized!')
            ->assertSeeText('You are not allowed to perform this operation!.');
    }

    public function testTrafoGetInstallDismantlePageAuthorized()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-install-dismantle')
            ->assertSeeText('Install dismantle')
            ->assertSeeText('Table')
            ->assertSeeText('Dismantle')
            ->assertSeeText('Dismantled equipment')
            ->assertSeeText('Install')
            ->assertSeeText('Installed equipment');
    }

    // POST
    public function testTrafoDoInstallDismantleSuccess()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $dismantle = Trafo::query()->find('ETF000085');
        self::assertEquals($dismantle->status, 'Installed');
        self::assertEquals($dismantle->funcloc, 'FP-01-IN1');
        self::assertEquals($dismantle->sort_field, 'TRAFO PLN');

        $install = Trafo::query()->find('ETF001234');
        self::assertEquals($install->status, 'Available');
        self::assertNull($install->funcloc);
        self::assertNull($install->sort_field);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->post('/trafo-install-dismantle', [
                'id_dismantle' => 'ETF000085',
                'id_install' => 'ETF001234',
            ])
            ->assertSeeText('[200] Success')
            ->assertSeeText('The trafo was successfully swapped.');

        $dismantled = Trafo::query()->find('ETF000085');
        self::assertNotEquals($dismantled->status, 'Installed');
        self::assertNotEquals($dismantled->funcloc, 'FP-01-IN1');
        self::assertNotEquals($dismantled->sort_field, 'TRAFO PLN');

        $installed = Trafo::query()->find('ETF001234');
        self::assertEquals($installed->status, 'Installed');
        self::assertEquals($installed->funcloc, 'FP-01-IN1');
        self::assertEquals($installed->sort_field, 'TRAFO PLN');
    }

    public function testTrafoDoInstallDismantleNull()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->post('/trafo-install-dismantle', [
                'id_dismantle' => null,
                'id_install' => null,
            ])
            ->assertSeeText('The id dismantle field is required.');
    }

    public function testTrafoDoInstallDismantleNullDismantleField()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->post('/trafo-install-dismantle', [
                'id_dismantle' => null,
                'id_install' => 'ETF001234',
            ])
            ->assertSeeText('The id dismantle field is required.');
    }

    public function testTrafoDoInstallDismantleNullInstallField()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->post('/trafo-install-dismantle', [
                'id_dismantle' => 'ETF000085',
                'id_install' => null,
            ])
            ->assertSeeText('The id install field is required.');
    }

    public function testTrafoDoInstallDismantleDismantleInvalid()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->post('/trafo-install-dismantle', [
                'id_dismantle' => 'ETF000000',
                'id_install' => 'ETF000026',
            ])
            ->assertSeeText('The selected id dismantle is invalid.');
    }

    public function testTrafoDoInstallDismantleInstallInvalid()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->post('/trafo-install-dismantle', [
                'id_dismantle' => 'ETF000085',
                'id_install' => 'ETF000000',
            ])
            ->assertSeeText('The selected id install is invalid.');
    }

    public function testTrafoDoInstallDismantleInstallDismantleNotDifferent()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->post('/trafo-install-dismantle', [
                'id_dismantle' => 'ETF000085',
                'id_install' => 'ETF000085',
            ])
            ->assertSeeText('The id dismantle field and id install must be different.');
    }

    public function testTrafoDoInstallDismantleInstallInvalidSize()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->post('/trafo-install-dismantle', [
                'id_dismantle' => 'ETF00085',
                'id_install' => 'ETF001234',
            ])
            ->assertSeeText('The id dismantle field must be 9 characters.');
    }

    public function testTrafoDoInstallDismantleDismantleInvalidSize()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->post('/trafo-install-dismantle', [
                'id_dismantle' => 'ETF000085',
                'id_install' => 'ETF01234',
            ])
            ->assertSeeText('The id install field must be 9 characters.');
    }

    // GET EQUIPMENT TRAFO AJAX
    // DISMANTLE
    public function testTrafoGetEquipmentDismantleValid()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-install-dismantle');

        $response = $this->post('/equipment-trafo', [
            'equipment' => 'ETF000085',
            'status' => 'Installed',
        ]);

        self::assertNotNull($response);
        $trafo = $response->baseResponse->original;
        self::assertEquals($trafo->funcloc, 'FP-01-IN1');
        self::assertEquals($trafo->material_number, null);
        self::assertEquals($trafo->unique_id, '1');
    }

    public function testTrafoGetEquipmentDismantleInvalid()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-install-dismantle');

        $response = $this->post('/equipment-trafo', [
            'equipment' => 'EMO000000',
            'status' => 'Installed',
        ]);

        self::assertNotNull($response);
        $trafo = $response->baseResponse->original;
        self::assertEmpty($trafo);
    }

    public function testTrafoGetEquipmentDismantleRepairedTrafo()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-install-dismantle');

        $response = $this->post('/equipment-trafo', [
            'equipment' => 'EMO004321', // repaired
            'status' => 'Installed',
        ]);

        self::assertNotNull($response);
        $trafo = $response->baseResponse->original;
        self::assertEmpty($trafo);
    }

    // INSTALL
    public function testTrafoGetEquipmentInstallValid()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-install-dismantle');

        $response = $this->post('/equipment-trafo', [
            'equipment' => 'ETF001234',
            'status' => 'Available',
        ]);

        self::assertNotNull($response);
        $trafo = $response->baseResponse->original;
        self::assertEquals($trafo->status, 'Available');
        self::assertNull($trafo->funcloc);
        self::assertNull($trafo->sort_field);
        self::assertEquals($trafo->unique_id, '11');
        self::assertEquals($trafo->qr_code_link, 'id=Fajar-TrafoList11');
    }

    public function testTrafoGetEquipmentInstallInvalid()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-install-dismantle');

        $response = $this->post('/equipment-trafo', [
            'equipment' => 'EMO000000',
            'status' => 'Available',
        ]);

        self::assertNotNull($response);
        $trafo = $response->baseResponse->original;
        self::assertEmpty($trafo);
    }

    public function testTrafoGetEquipmentInstallRepairedTrafo()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafo-install-dismantle');

        $response = $this->post('/equipment-trafo', [
            'equipment' => 'EMO004321', // repaired
            'status' => 'Installed',
        ]);

        self::assertNotNull($response);
        $trafo = $response->baseResponse->original;
        self::assertEmpty($trafo);
    }
}
