<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecordControllerTest extends TestCase
{
    public function testGetCheckingFormNotFound()
    {
        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/scanner');

        $this->followingRedirects()
            ->get('/checking-form/Fajar-MotorList987')
            ->assertSeeText('[404] Not found.')
            ->assertSeeText('The motor with id 987 was not found.');
    }

    public function testGetCheckingFormInvalid()
    {
        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/scanner');

        $this->followingRedirects()
            ->get('/checking-form/Fajar-Invalid123')
            ->assertSeeText('[404] Not found.')
            ->assertSeeText('The scanned qr code not found.');
    }

    public function testGetCheckingValidSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ]);

        $this->get('/checking-form/Fajar-MotorList2100')
            ->assertSeeText('FP-01-PM3-REL-PPRL-PRAR')
            ->assertSeeText('MGM000481')
            ->assertSeeText('Motor status')
            ->assertSee('Running')
            ->assertSee('Not Running')
            ->assertSeeText('Cleanliness')
            ->assertSee('Clean')
            ->assertSee('Dirty')
            ->assertSeeText('Nipple grease')
            ->assertSee('Available')
            ->assertSee('Not Available')
            ->assertSeeText('Number of greasing')
            ->assertSeeText('Left side')
            ->assertSeeText('Front side')
            ->assertSeeText('IEC 60085')
            ->assertSeeText('Temperature de')
            ->assertSeeText('Temperature body')
            ->assertSeeText('Temperature nde')
            ->assertSeeText('Vibration standard')
            ->assertSee('Good')
            ->assertSee('Satisfactory')
            ->assertSee('Unsatisfactory')
            ->assertSee('Unacceptable')
            ->assertSeeText('Vibration inspection guide')
            ->assertSeeText('Vibration de vertical')
            ->assertSeeText('Vibration de horizontal')
            ->assertSeeText('Vibration de axial')
            ->assertSeeText('Vibration de frame')
            ->assertSeeText('Noise de')
            ->assertSee('Normal')
            ->assertSee('Abnormal')
            ->assertSeeText('Vibration nde vertical')
            ->assertSeeText('Vibration nde vertical')
            ->assertSeeText('Vibration nde horizontal')
            ->assertSeeText('Finding')
            ->assertSee('Description of findings if any')
            ->assertSeeText('Finding attachment')
            ->assertSee('Submit');
    }

    // POST
    public function testPostRecordMotorSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/checking-form/Fajar-MotorList2100');

        $this->followingRedirects()
            ->post('/record-motor', [
                'id' => uniqid(),
                'funcloc' => "FP-01-PM3-REL-PPRL-PRAR",
                'motor' => "MGM000481",
                'sort_field' => "PM3.REEL.PRAR/GM",
                'motor_status' => "Running",
                'cleanliness' => "Clean",
                'nipple_grease' => "Available",
                'number_of_greasing' => "123",
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => "30.09",
                'vibration_de_vertical_value' => "0.71",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => "Satisfactory",
                'vibration_nde_horizontal_value' => "4.50",
                'vibration_nde_horizontal_desc' => "Unsatisfactory",
                'vibration_nde_frame_value' => "45",
                'vibration_nde_frame_desc' => "Unacceptable",
                'noise_nde' => "Abnormal",
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }
}
