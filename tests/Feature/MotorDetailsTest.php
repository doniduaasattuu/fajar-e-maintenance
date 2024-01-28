<?php

namespace Tests\Feature;

use App\Models\MotorDetails;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorDetailsSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class MotorDetailsTest extends TestCase
{
    public function testMotorDetailsRelationToMotor()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        $motorDetail = MotorDetails::query()->with(['Motor'])->where('motor_detail', 'EMO000426')->first();
        self::assertNotNull($motorDetail);
        $motor = $motorDetail->Motor;
        self::assertNotNull($motor);
        self::assertEquals('EMO000426', $motor->id);
        self::assertEquals('1804', $motor->unique_id);
    }

    public function testMotorDetailsRelationToMotorNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        $motorDetail = MotorDetails::query()->with(['Motor'])->where('motor_detail', 'EMO000008')->first();
        self::assertNull($motorDetail);
    }

    public function testMotorDetailsRelationToFuncloc()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        $motorDetail = MotorDetails::query()->with(['Motor', 'Funcloc'])->where('motor_detail', 'EMO000426')->first();
        self::assertNotNull($motorDetail);
        $funcloc = $motorDetail->Funcloc;
        self::assertNotNull($funcloc);
        self::assertEquals('PM3.SUM.P70', $funcloc->description);
    }

    public function testMotorDetailsRelationToFunclocNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        $motorDetail = MotorDetails::query()->with(['Motor', 'Funcloc'])->where('motor_detail', 'EMO000023')->first();
        self::assertNull($motorDetail);
    }

    // MOTOR CONTROLLER
    public function testSeedFuncloc()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->post('/funcloc-register', [
            'id' => 'FP-01-PM3-OCC-PU01',
            'description' => 'SP3.SP-03/M',
        ]);

        $this->get('/motor-registration')
            ->assertDontSeeText('Update')
            ->assertSeeText('Submit');
    }

    public function testRegisterMotorDetailSuccess()
    {
        $this->testSeedFuncloc();

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

    public function testRegisterMotorDetailManufacturerInvalidLength()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc Is Invalid Length',
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
                'manufacturer' => 'The manufacturer field must not be greater than 50 characters.'
            ]);
    }

    public function testRegisterMotorDetailSerialNumberInvalidLength()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => 'This is invalid maximum length serial number because maximum allowed length is 50 characters.',
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
                'serial_number' => 'The serial number field must not be greater than 50 characters.'
            ]);
    }

    public function testRegisterMotorDetailTypeInvalidLength()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'This is invalid maximum length type because maximum allowed length is 50 characters.',
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
                'type' => 'The type field must not be greater than 50 characters.'
            ]);
    }

    public function testRegisterMotorDetailPowerRateInvalidLength()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '1100/1100/AS',
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
                'power_rate' => 'The power rate field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailPowerUnitInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'Not Available',
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
                'power_unit' => 'The selected power unit is invalid.'
            ]);
    }

    public function testRegisterMotorDetailVoltageInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400/400/100',
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
                'voltage' => 'The voltage field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailElectricalCurrentInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'Alternating Current',
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
                'electrical_current' => 'The selected electrical current is invalid.'
            ]);
    }

    public function testRegisterMotorDetailCurrentNominalInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400/400/100',
                'electrical_current' => 'AC',
                'current_nominal' => '1200A/1005A',
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
                'current_nominal' => 'The current nominal field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailFrequencyInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz/10Hz',
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
                'frequency' => 'The frequency field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailPoleInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '9500P/4POLE',
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
                'pole' => 'The pole field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailRpmInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '2500/5011/100',
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
                'rpm' => 'The rpm field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailBearingDeInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => 'This is invalid maximum length serial number because maximum allowed length is 25 characters.',
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
                'bearing_de' => 'The bearing de field must not be greater than 25 characters.'
            ]);
    }

    public function testRegisterMotorDetailBearingNdeInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => 'This is invalid maximum length bearing nde because maximum allowed length is 25 characters.',
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
                'bearing_nde' => 'The bearing nde field must not be greater than 25 characters.'
            ]);
    }

    public function testRegisterMotorDetailFrameTypeInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'This is invalid maximum length frame type because maximum allowed length is 25 characters.',
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
                'frame_type' => 'The frame type field must not be greater than 25 characters.'
            ]);
    }

    public function testRegisterMotorDetailShaftDiameterInvalidLength()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => 'This is invalid diameter length: 150 cm',
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
                'shaft_diameter' => 'The shaft diameter field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailPhaseSupplyInvalidType()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3a',
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
                'phase_supply' => 'The phase supply field must be a number.'
            ]);
    }

    public function testRegisterMotorDetailPhaseSupplyInvalidLength()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '4',
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
                'phase_supply' => 'The phase supply field must be between 1 and 3 digits.',
                'phase_supply' => 'The phase supply field must not be greater than 3.'
            ]);
    }

    public function testRegisterMotorDetailCosPhiInvalidLengthMax()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => 'This is invalid cos phi value: 0.98',
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
                'cos_phi' => 'The cos phi field must not be greater than 10 characters.',
            ]);
    }

    public function testRegisterMotorDetailCosPhiDecimalSuccess()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
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
            ->assertSessionHasNoErrors([
                'cos_phi' => 'The cos phi field must have 2 decimal places.',
            ]);
    }

    // EFFICIENCY
    public function testRegisterMotorDetailEfficiencyInvalidLengthMax()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.85',
                'efficiency' => 'This is invalid length efficiency: 0.98 %',
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
                'efficiency' => 'The efficiency field must not be greater than 10 characters.',
            ]);
    }

    public function testRegisterMotorDetailEfficiencyDecimalSuccess()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
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
            ->assertSessionHasNoErrors([
                'efficiency' => 'The efficiency field must have 2 decimal places.',
            ]);
    }


    public function testRegisterMotorDetailIpRatingInvalidMaxLength()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'This is invalid IP Rating',
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
                'ip_rating' => 'The ip rating field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailInsulationClassInvalidMaxLength()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'This is invalid',
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
                'insulation_class' => 'The insulation class field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailDutyInvalidMaxLength()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'This is invalid',
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
                'duty' => 'The duty field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailConnectinTypeMaxLength()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'This is invalid connection type',
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
                'connection_type' => 'The connection type field must not be greater than 25 characters.'
            ]);
    }

    public function testRegisterMotorDetailNippleGreaseInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Unknown',
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
                'nipple_grease' => 'The selected nipple grease is invalid.'
            ]);
    }

    public function testRegisterMotorDetailNippleGreaseSuccess()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Not Available',
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
            ->assertSessionHasNoErrors([
                'nipple_grease' => 'The selected nipple grease is invalid.'
            ]);
    }

    public function testRegisterMotorDetailGreasingType()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'This is invalid max length of greasing type value becase max length is 25 characters',
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
                'greasing_type' => 'The greasing type field must not be greater than 25 characters.'
            ]);
    }

    public function testRegisterMotorDetailGreasingDeInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'Unirex 77',
                'greasing_qty_de' => 'This is invalid greasing qty de',
                'greasing_qty_nde' => null,
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSessionHasErrors([
                'greasing_qty_de' => 'The greasing qty de field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailGreasingNdeInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'Unirex 77',
                'greasing_qty_de' => '76 grm',
                'greasing_qty_nde' => 'This is invalid greasing qty de',
                'length' => null,
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSessionHasErrors([
                'greasing_qty_nde' => 'The greasing qty nde field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailLengthInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'Unirex 77',
                'greasing_qty_de' => '76 grm',
                'greasing_qty_nde' => 'This is invalid greasing qty de',
                'length' => 'This is invalid length',
                'width' => null,
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSessionHasErrors([
                'length' => 'The length field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailWidthInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'Unirex 77',
                'greasing_qty_de' => '76 grm',
                'greasing_qty_nde' => 'This is invalid greasing qty de',
                'length' => '250 cm',
                'width' => 'This is invalid length',
                'height' => null,
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSessionHasErrors([
                'width' => 'The width field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailHeightInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'Unirex 77',
                'greasing_qty_de' => '76 grm',
                'greasing_qty_nde' => 'This is invalid greasing qty de',
                'length' => '250 cm',
                'width' => '80 cm',
                'height' => 'This is invalid height',
                'weight' => null,
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSessionHasErrors([
                'height' => 'The height field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailWeightInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'Unirex 77',
                'greasing_qty_de' => '76 grm',
                'greasing_qty_nde' => 'This is invalid greasing qty de',
                'length' => '250 cm',
                'width' => '80 cm',
                'height' => '75 cm',
                'weight' => 'This is invalid weight',
                'cooling_fan' => null,
                'mounting' => null,
            ])
            ->assertSessionHasErrors([
                'weight' => 'The weight field must not be greater than 10 characters.'
            ]);
    }

    public function testRegisterMotorDetailCoolingFanInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'Unirex 77',
                'greasing_qty_de' => '76 grm',
                'greasing_qty_nde' => 'This is invalid greasing qty de',
                'length' => '250 cm',
                'width' => '80 cm',
                'height' => '75 cm',
                'weight' => '250 kg',
                'cooling_fan' => 'Available',
                'mounting' => null,
            ])
            ->assertSessionHasErrors([
                'cooling_fan' => 'The selected cooling fan is invalid.'
            ]);
    }

    public function testRegisterMotorDetailCoolingFanInternalSuccess()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'Unirex 77',
                'greasing_qty_de' => '76 grm',
                'greasing_qty_nde' => '76 grm',
                'length' => '250 cm',
                'width' => '80 cm',
                'height' => '75 cm',
                'weight' => '250 kg',
                'cooling_fan' => 'Internal',
                'mounting' => null,
            ])
            ->assertSessionHasNoErrors([
                'cooling_fan' => 'The selected cooling fan is invalid.'
            ]);
    }

    public function testRegisterMotorDetailCoolingFanExternalSuccess()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'Unirex 77',
                'greasing_qty_de' => '76 grm',
                'greasing_qty_nde' => '76 grm',
                'length' => '250 cm',
                'width' => '80 cm',
                'height' => '75 cm',
                'weight' => '250 kg',
                'cooling_fan' => 'External',
                'mounting' => null,
            ])
            ->assertSessionHasNoErrors([
                'cooling_fan' => 'The selected cooling fan is invalid.'
            ]);
    }

    public function testRegisterMotorDetailCoolingFanNotAvailableSuccess()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'Unirex 77',
                'greasing_qty_de' => '76 grm',
                'greasing_qty_nde' => '76 grm',
                'length' => '250 cm',
                'width' => '80 cm',
                'height' => '75 cm',
                'weight' => '250 kg',
                'cooling_fan' => 'Not Available',
                'mounting' => null,
            ])
            ->assertSessionHasNoErrors([
                'cooling_fan' => 'The selected cooling fan is invalid.'
            ]);
    }

    public function testRegisterMotorDetailMountingInvalid()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'Unirex 77',
                'greasing_qty_de' => '76 grm',
                'greasing_qty_nde' => '76 grm',
                'length' => '250 cm',
                'width' => '80 cm',
                'height' => '75 cm',
                'weight' => '250 kg',
                'cooling_fan' => 'Internal',
                'mounting' => 'Available',
            ])
            ->assertSessionHasErrors([
                'mounting' => 'The selected mounting is invalid.'
            ]);
    }

    public function testRegisterMotorDetailMountingHorizontalSuccess()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'Unirex 77',
                'greasing_qty_de' => '76 grm',
                'greasing_qty_nde' => '76 grm',
                'length' => '250 cm',
                'width' => '80 cm',
                'height' => '75 cm',
                'weight' => '250 kg',
                'cooling_fan' => 'Internal',
                'mounting' => 'Horizontal',
            ])
            ->assertSessionHasNoErrors([
                'mounting' => 'The selected mounting is invalid.'
            ]);
    }

    public function testRegisterMotorDetailMountingVerticalSuccess()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'Unirex 77',
                'greasing_qty_de' => '76 grm',
                'greasing_qty_nde' => '76 grm',
                'length' => '250 cm',
                'width' => '80 cm',
                'height' => '75 cm',
                'weight' => '250 kg',
                'cooling_fan' => 'Internal',
                'mounting' => 'Vertical',
            ])
            ->assertSessionHasNoErrors([
                'mounting' => 'The selected mounting is invalid.'
            ]);
    }

    public function testRegisterMotorDetailMountingVhSuccess()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'Unirex 77',
                'greasing_qty_de' => '76 grm',
                'greasing_qty_nde' => '76 grm',
                'length' => '250 cm',
                'width' => '80 cm',
                'height' => '75 cm',
                'weight' => '250 kg',
                'cooling_fan' => 'Internal',
                'mounting' => 'V/H',
            ])
            ->assertSessionHasNoErrors([
                'mounting' => 'The selected mounting is invalid.'
            ]);
    }

    public function testRegisterMotorDetailMountingMgmSuccess()
    {
        $this->testSeedFuncloc();

        $this
            ->post('/motor-register', [
                'id' => 'EMO000123',
                'status' => 'Installed',
                'funcloc' => 'FP-01-PM3-OCC-PU01',
                'sort_field' => 'SP3.SP-03/M',
                'description' => 'AC MOTOR,350kW,4P,132A,3kV,1500RPM',
                'material_number' => '10012345',
                'unique_id' => '123',
                'qr_code_link' => 'https://www.safesave.info/MIC.php?id=Fajar-MotorList123',

                'manufacturer' => 'M.G.M. Electric Motors North America Inc',
                'serial_number' => '3 6V A073001 ASA',
                'type' => 'W0101',
                'power_rate' => '11',
                'power_unit' => 'kW',
                'voltage' => '400',
                'electrical_current' => 'AC',
                'current_nominal' => '22.5',
                'frequency' => '50Hz/60Hz',
                'pole' => '4P',
                'rpm' => '1500/1800',
                'bearing_de' => '6205',
                'bearing_nde' => '6205',
                'frame_type' => 'AEEB 250',
                'shaft_diameter' => '150 mm',
                'phase_supply' => '3',
                'cos_phi' => '0.89',
                'efficiency' => '0.89',
                'ip_rating' => 'IP65',
                'insulation_class' => 'F',
                'duty' => 'S1',
                'connection_type' => 'Star/Delta',
                'nipple_grease' => 'Available',
                'greasing_type' => 'Unirex 77',
                'greasing_qty_de' => '76 grm',
                'greasing_qty_nde' => '76 grm',
                'length' => '250 cm',
                'width' => '80 cm',
                'height' => '75 cm',
                'weight' => '250 kg',
                'cooling_fan' => 'Internal',
                'mounting' => 'MGM',
            ])
            ->assertSessionHasNoErrors([
                'mounting' => 'The selected mounting is invalid.'
            ]);
    }
}
