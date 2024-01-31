<?php

namespace Tests\Feature;

use App\Models\TrafoDetails;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TrafoDetailsSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrafoDetailsTest extends TestCase
{
    public function testTrafoDetailsRelationToTrafo()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        $trafoDetail = TrafoDetails::query()->with(['Trafo'])->where('trafo_detail', 'ETF000060')->first();
        self::assertNotNull($trafoDetail);
        $trafo = $trafoDetail->Trafo;
        self::assertNotNull($trafo);
        self::assertEquals('ETF000060', $trafo->id);
        self::assertEquals('id=Fajar-TrafoList3', $trafo->qr_code_link);
    }

    public function testTrafoDetailsRelationToTrafoNull()
    {
        $this->seed([FunclocSeeder::class, trafoSeeder::class, trafoDetailsSeeder::class]);

        $trafoDetail = TrafoDetails::query()->with(['Trafo'])->where('trafo_detail', 'ETF000000')->first();
        self::assertNull($trafoDetail);
    }

    public function testTrafoDetailsRelationToFuncloc()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        $trafoDetail = TrafoDetails::query()->with(['Trafo', 'Funcloc'])->where('trafo_detail', 'ETF000027')->first();
        self::assertNotNull($trafoDetail);
        $funcloc = $trafoDetail->Funcloc;
        self::assertNotNull($funcloc);
        self::assertEquals('Trafo PLN1', $funcloc->description);
    }

    public function testTrafoDetailsRelationToFunclocNull()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        $trafoDetail = TrafoDetails::query()->with(['Trafo', 'Funcloc'])->where('trafo_detail', 'ETF001234')->first();
        self::assertNull($trafoDetail);
    }

    // MOTOR CONTROLLER
    public function testRegisterTrafoDetailSuccess()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
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

    // POWER RATE
    public function testRegisterTrafoDetailPowerRateInvalidLengthMax()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '30000000000',
                'power_unit' => 'VA',
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
                'power_rate' => 'The power rate field must not be greater than 10 characters.'
            ]);
    }

    // POWER UNIT
    public function testRegisterTrafoDetailPowerUnitInvalid()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '0.3',
                'power_unit' => 'GVA',
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
                'power_unit' => 'The selected power unit is invalid.'
            ]);
    }

    public function testRegisterTrafoDetailPowerUnitVaSuccess()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000000',
                'power_unit' => 'VA',
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

    public function testRegisterTrafoDetailPowerUnitKvaSuccess()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
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

    public function testRegisterTrafoDetailPowerUnitMvaSuccess()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3',
                'power_unit' => 'MVA',
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

    // PRIMARY VOLTAGE
    public function testRegisterTrafoDetailPrimaryVoltageInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000000000',
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
                'primary_voltage' => 'The primary voltage field must not be greater than 10 characters.'
            ]);
    }

    // SECONDARY VOLTAGE
    public function testRegisterTrafoDetailSecondaryVoltageInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '40000000000',
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
                'secondary_voltage' => 'The secondary voltage field must not be greater than 10 characters.'
            ]);
    }

    // PRIMARY CURRENT
    public function testRegisterTrafoDetailPrimaryCurrentInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.60000000',
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
                'primary_current' => 'The primary current field must not be greater than 10 characters.'
            ]);
    }

    // SECONDARY CURRENT
    public function testRegisterTrafoDetailSecondaryCurrentInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.60',
                'secondary_current' => '4330.1000000',
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
                'secondary_current' => 'The secondary current field must not be greater than 10 characters.'
            ]);
    }

    // PRIMARY CONNECTION TYPE
    public function testRegisterTrafoDetailPrimaryConnectionTypeInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'THIS IS INVALID',
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
                'primary_connection_type' => 'The primary connection type field must not be greater than 10 characters.'
            ]);
    }

    // SECONDARY CONNECTION TYPE
    public function testRegisterTrafoDetailSecondaryConnectionTypeInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'THIS IS INVALID',
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
                'secondary_connection_type' => 'The secondary connection type field must not be greater than 10 characters.'
            ]);
    }

    // FREQUENCY
    public function testRegisterTrafoDetailFrequencyTypeInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'STAR',
                'frequency' => 'THIS IS INVALID MAX LENGTH',
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
                'frequency' => 'The frequency field must not be greater than 10 characters.'
            ]);
    }

    // TYPE
    public function testRegisterTrafoDetailTypeInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'STAR',
                'frequency' => '50 Hz',
                'type' => 'Step',
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
                'type' => 'The selected type is invalid.'
            ]);
    }

    public function testRegisterTrafoDetailTypeStepUpSuccess()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000',
                'secondary_voltage' => '150000',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'STAR',
                'frequency' => '50 Hz',
                'type' => 'Step up',
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

    public function testRegisterTrafoDetailTypeStepDownSuccess()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this->followingRedirects()
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000 kV',
                'secondary_voltage' => '400 V',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'STAR',
                'frequency' => '50 Hz',
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

    // MANUFACTURER
    public function testRegisterTrafoDetailManufacturerInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000 kV',
                'secondary_voltage' => '400 V',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'STAR',
                'frequency' => '50 Hz',
                'type' => 'Step down',
                'manufacturer' => 'This is invalid length of manufacturer because max is 50 characters',
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
                'manufacturer' => 'The manufacturer field must not be greater than 50 characters.'
            ]);
    }

    // YEAR OF MANUFACTURE
    public function testRegisterTrafoDetailYearOfManufactureInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000 kV',
                'secondary_voltage' => '400 V',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'STAR',
                'frequency' => '50 Hz',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010/2021',
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
                'year_of_manufacture' => 'The year of manufacture field must be 4 characters.'
            ]);
    }

    // SERIAL NUMBER
    public function testRegisterTrafoDetailSerialNumberInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000 kV',
                'secondary_voltage' => '400 V',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'STAR',
                'frequency' => '50 Hz',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '1033894923423684234hdfbsjdfn?SLF;sfSDf s;opw8ryp937o 23grviwuerlawi euglawievwurg;i',
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
                'serial_number' => 'The serial number field must not be greater than 25 characters.'
            ]);
    }

    // VECTOR GROUP
    public function testRegisterTrafoDetailVectorGroupInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000 kV',
                'secondary_voltage' => '400 V',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'STAR',
                'frequency' => '50 Hz',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '1033894923',
                'vector_group' => 'Dyn5 Invalid max length because max length is 25 characters',
                'insulation_class' => null,
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'vector_group' => 'The vector group field must not be greater than 25 characters.'
            ]);
    }

    // VECTOR GROUP
    public function testRegisterTrafoDetailInsulationClassInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000 kV',
                'secondary_voltage' => '400 V',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'STAR',
                'frequency' => '50 Hz',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '1033894923',
                'vector_group' => 'Dyn5',
                'insulation_class' => 'This is invalid insulation class',
                'type_of_cooling' => 'ONAN',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'insulation_class' => 'The insulation class field must not be greater than 10 characters.'
            ]);
    }

    // TYPE OF COOLING
    public function testRegisterTrafoDetailTypeOfCoolingInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000 kV',
                'secondary_voltage' => '400 V',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'STAR',
                'frequency' => '50 Hz',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '1033894923',
                'vector_group' => 'Dyn5',
                'insulation_class' => 'F',
                'type_of_cooling' => 'ONAN/ONAF/OLAF',
                'temp_rise_oil_winding' => null,
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'type_of_cooling' => 'The type of cooling field must not be greater than 10 characters.'
            ]);
    }

    // TEMP RISE OF OIL WINDING
    public function testRegisterTrafoDetailTempRiseOfOilWindingInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000 kV',
                'secondary_voltage' => '400 V',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'STAR',
                'frequency' => '50 Hz',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '1033894923',
                'vector_group' => 'Dyn5',
                'insulation_class' => 'F',
                'type_of_cooling' => 'ONAN/ONAF',
                'temp_rise_oil_winding' => 'This is invalid length of temp rise oil winding',
                'weight' => null,
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'temp_rise_oil_winding' => 'The temp rise oil winding field must not be greater than 25 characters.'
            ]);
    }

    // WEIGHT
    public function testRegisterTrafoDetailWeightInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000 kV',
                'secondary_voltage' => '400 V',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'STAR',
                'frequency' => '50 Hz',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '1033894923',
                'vector_group' => 'Dyn5',
                'insulation_class' => 'F',
                'type_of_cooling' => 'ONAN/ONAF',
                'temp_rise_oil_winding' => null,
                'weight' => 'This is invalid length of weight',
                'weight_of_oil' => null,
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'weight' => 'The weight field must not be greater than 25 characters.'
            ]);
    }

    // WEIGHT OF OIL
    public function testRegisterTrafoDetailWeightOfOilInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000 kV',
                'secondary_voltage' => '400 V',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'STAR',
                'frequency' => '50 Hz',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '1033894923',
                'vector_group' => 'Dyn5',
                'insulation_class' => 'F',
                'type_of_cooling' => 'ONAN/ONAF',
                'temp_rise_oil_winding' => null,
                'weight' => '5 ton',
                'weight_of_oil' => 'This is invalid length of weight',
                'oil_type' => null,
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'weight_of_oil' => 'The weight of oil field must not be greater than 25 characters.'
            ]);
    }

    // OIL TYPE
    public function testRegisterTrafoDetailOilTypeInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000 kV',
                'secondary_voltage' => '400 V',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'STAR',
                'frequency' => '50 Hz',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '1033894923',
                'vector_group' => 'Dyn5',
                'insulation_class' => 'F',
                'type_of_cooling' => 'ONAN/ONAF',
                'temp_rise_oil_winding' => null,
                'weight' => '5 ton',
                'weight_of_oil' => '90 kg',
                'oil_type' => 'This is invalid length of weight',
                'ip_rating' => null,
            ])
            ->assertSessionHasErrors([
                'oil_type' => 'The oil type field must not be greater than 25 characters.'
            ]);
    }

    // IP RATING
    public function testRegisterTrafoDetailIpRatingInvalidLength()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/trafo-registration');

        $this
            ->post('/trafo-register', [
                'id' => 'ETF000010',
                'status' => 'Available',
                'funcloc' => null,
                'sort_field' => null,
                'description' => 'TR INCHENERATOR#2',
                'material_number' => '10010900',
                'unique_id' => '13',
                'qr_code_link' => 'id=Fajar-TrafoList13',
                'trafo_detail' => 'ETF000010',
                'power_rate' => '3000',
                'power_unit' => 'kVA',
                'primary_voltage' => '20000 kV',
                'secondary_voltage' => '400 V',
                'primary_current' => '86.60',
                'secondary_current' => '4330.10',
                'primary_connection_type' => 'DELTA',
                'secondary_connection_type' => 'STAR',
                'frequency' => '50 Hz',
                'type' => 'Step down',
                'manufacturer' => 'Trafindo',
                'year_of_manufacture' => '2010',
                'serial_number' => '1033894923',
                'vector_group' => 'Dyn5',
                'insulation_class' => 'F',
                'type_of_cooling' => 'ONAN/ONAF',
                'temp_rise_oil_winding' => null,
                'weight' => '5 ton',
                'weight_of_oil' => '90 kg',
                'oil_type' => 'Omega',
                'ip_rating' => 'This is invalid length of weight',
            ])
            ->assertSessionHasErrors([
                'ip_rating' => 'The ip rating field must not be greater than 25 characters.'
            ]);
    }
}
