<?php

namespace Tests\Feature;

use App\Models\Motor;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MotorDetailTest extends TestCase
{
    public function testSeedFuncloc()
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
    }
    public function testRegisterMotorDetail()
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
}
