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

    // FUNCLOC
    public function testPostRecordMotorFunclocNull()
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
                'funcloc' => null,
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
            ->assertSeeText('The data you submitted is invalid.');
    }


    public function testPostRecordMotorFunclocInvalid()
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
                'funcloc' => 'FP-01-PM7',
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
            ->assertSeeText('The data you submitted is invalid.');
    }

    // ID MOTOR
    public function testPostRecordMotorIdMotorNull()
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
                'motor' => null,
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
            ->assertSeeText('The data you submitted is invalid.');
    }

    public function testPostRecordMotorIdMotorInvalid()
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
                'motor' => 'EMO000456',
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
            ->assertSeeText('The data you submitted is invalid.');
    }

    // SORT FIELD
    public function testPostRecordMotorSortFieldNull()
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
                'motor' => 'MGM000481',
                'sort_field' => null,
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
            ->assertSeeText('The data you submitted is invalid.');
    }

    // MOTOR STATUS
    public function testPostRecordMotorMotorStatusNull()
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
                'motor' => 'MGM000481',
                'sort_field' => "PM3.REEL.PRAR/GM",
                'motor_status' => null,
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
            ->assertSeeText('The motor status field is required.');
    }

    public function testPostRecordMotorMotorStatusInvalid()
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
                'motor' => 'MGM000481',
                'sort_field' => "PM3.REEL.PRAR/GM",
                'motor_status' => 'Not Available',
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
            ->assertSeeText('The selected motor status is invalid.');
    }

    public function testPostRecordMotorMotorStatusRunningSucess()
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

    public function testPostRecordMotorMotorStatusNotRunningSucess()
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
                'motor_status' => "Not Running",
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

    // CLEANLINESS
    public function testPostRecordMotorCleanlinessNull()
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
                'cleanliness' => null,
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
            ->assertSeeText('The cleanliness field is required.');
    }

    public function testPostRecordMotorCleanlinessInvalid()
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
                'cleanliness' => 'Not Available',
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
            ->assertSeeText('The selected cleanliness is invalid.');
    }

    public function testPostRecordMotorCleanlinessCleanSuccess()
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
                'cleanliness' => 'Clean',
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

    public function testPostRecordMotorCleanlinessDirtySuccess()
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
                'cleanliness' => 'Dirty',
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

    // NIPPLE GREASE
    public function testPostRecordMotorNippleGreaseNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => null,
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
            ->assertSeeText('The nipple grease field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorNippleGreaseInvalid()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Success',
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
            ->assertSeeText('The selected nipple grease is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorNippleGreaseAvailableSuccess()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
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

    public function testPostRecordMotorNippleGreaseNotAvailableSuccess()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Not Available',
                'number_of_greasing' => null,
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

    // NUMBER OF GREASING
    public function testPostRecordMotorNumberOfGreasingNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Not Available',
                'number_of_greasing' => null,
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

    public function testPostRecordMotorNumberOfGreasingFilled()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Not Available',
                'number_of_greasing' => '100',
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
            ->assertSeeText('The number of greasing field is prohibited when nipple grease is Not Available.');
    }

    public function testPostRecordMotorNumberOfGreasingInvalidMax()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '256',
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
            ->assertSeeText('The number of greasing field must not be greater than 255.');
    }

    public function testPostRecordMotorNumberOfGreasingInvalidType()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => 'abc',
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
            ->assertSeeText('The number of greasing field must be an integer.');
    }

    public function testPostRecordMotorNumberOfGreasingInvalidTypeComa()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '10,00',
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
            ->assertSeeText('The number of greasing field must be an integer.');
    }

    public function testPostRecordMotorNumberOfGreasingSuccess()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
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
            ->assertDontSeeText('The number of greasing field must be an integer.')
            ->assertSeeText('The motor record successfully saved.');
    }

    // TEMPERATURE DE
    public function testPostRecordMotorTemperatureDeNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => null,
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

    public function testPostRecordMotorTemperatureDeInvalidDecimal()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => '10,00',
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
            ->assertSeeText('The temperature de field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorTemperatureDeInvalidMin()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => '10',
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
            ->assertSeeText('The temperature de field must be at least 15.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorTemperatureDeInvalidMax()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => '256',
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
            ->assertSeeText('The temperature de field must not be greater than 255.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // TEMPERATURE BODY
    public function testPostRecordMotorTemperatureBodyNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => null,
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

    public function testPostRecordMotorTemperatureBodyInvalidDecimal()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => '10,00',
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
            ->assertSeeText('The temperature body field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorTemperatureBodyInvalidMin()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => '10',
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
            ->assertSeeText('The temperature body field must be at least 15.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorTemperatureBodyInvalidMax()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => '256',
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
            ->assertSeeText('The temperature body field must not be greater than 255.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // TEMPERATURE NDE
    public function testPostRecordMotorTemperatureNdeNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => null,
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

    public function testPostRecordMotorTemperatureNdeInvalidDecimal()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '10,00',
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
            ->assertSeeText('The temperature nde field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorTemperatureNdeInvalidMin()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '10',
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
            ->assertSeeText('The temperature nde field must be at least 15.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorTemperatureNdeInvalidMax()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '256',
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
            ->assertSeeText('The temperature nde field must not be greater than 255.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DEV VALUE
    public function testPostRecordMotorVibrationDeVerticalNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => null,
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

    public function testPostRecordMotorVibrationDeVerticalInvalidDecimal()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '10.2.1',
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
            ->assertSeeText('The vibration de vertical value field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeVerticalInvalidMin()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '-1',
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
            ->assertSeeText('The vibration de vertical value field must be at least 0.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeVerticalInvalidMax()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '45.01',
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
            ->assertSeeText('The vibration de vertical value field must not be greater than 45.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DE VERTICAL DESC
    public function testPostRecordMotorVibrationDeVerticalDescNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '1.80',
                'vibration_de_vertical_desc' => null,
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
            ->assertSeeText('The vibration de vertical desc field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeVerticalDescInvalid()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '1.80',
                'vibration_de_vertical_desc' => 'Lumayan',
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
            ->assertSeeText('The selected vibration de vertical desc is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DEH VALUE
    public function testPostRecordMotorVibrationDeHorizontalNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => null,
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

    public function testPostRecordMotorVibrationDeHorizontalInvalidDecimal()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => '10.2.1',
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
            ->assertSeeText('The vibration de horizontal value field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeHorizontalInvalidMin()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => '-1',
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
            ->assertSeeText('The vibration de horizontal value field must be at least 0.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeHorizontalInvalidMax()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => '45.01',
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
            ->assertSeeText('The vibration de horizontal value field must not be greater than 45.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DE HORIZONTAL DESC
    public function testPostRecordMotorVibrationDeHorizontalDescNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '1.80',
                'vibration_de_vertical_desc' => "Satisfactory",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => null,
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
            ->assertSeeText('The vibration de horizontal desc field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeHorizontalDescInvalid()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '1.80',
                'vibration_de_vertical_desc' => "Satisfactory",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => 'Lumayan',
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
            ->assertSeeText('The selected vibration de horizontal desc is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DEA VALUE
    public function testPostRecordMotorVibrationDeAxialNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => null,
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

    public function testPostRecordMotorVibrationDeAxialInvalidDecimal()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => '10.2.1',
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
            ->assertSeeText('The vibration de axial value field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeAxialInvalidMin()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => '-1',
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
            ->assertSeeText('The vibration de axial value field must be at least 0.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeAxialInvalidMax()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => '45.01',
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
            ->assertSeeText('The vibration de axial value field must not be greater than 45.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DE AXIAL DESC
    public function testPostRecordMotorVibrationDeAxialDescNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '1.80',
                'vibration_de_vertical_desc' => "Satisfactory",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => "Unsatisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => null,
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
            ->assertSeeText('The vibration de axial desc field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeAxialDescInvalid()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '1.80',
                'vibration_de_vertical_desc' => "Satisfactory",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => "Unsatisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => 'Lumayan',
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
            ->assertSeeText('The selected vibration de axial desc is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DEF VALUE
    public function testPostRecordMotorVibrationDeFrameNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "45",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => null,
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

    public function testPostRecordMotorVibrationDeFrameInvalidDecimal()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "45",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => '10.2.1',
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
            ->assertSeeText('The vibration de frame value field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeFrameInvalidMin()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "45",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => '-1',
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
            ->assertSeeText('The vibration de frame value field must be at least 0.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeFrameInvalidMax()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "45",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => '45.01',
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
            ->assertSeeText('The vibration de frame value field must not be greater than 45.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DE FRAME DESC
    public function testPostRecordMotorVibrationDeFrameDescNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '1.80',
                'vibration_de_vertical_desc' => "Satisfactory",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => "Unsatisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unacceptable",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => null,
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
            ->assertSeeText('The vibration de frame desc field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeFrameDescInvalid()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '1.80',
                'vibration_de_vertical_desc' => "Satisfactory",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => "Unsatisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unacceptable",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => 'Lumayan',
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
            ->assertSeeText('The selected vibration de frame desc is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // NOISE DE
    public function testPostRecordMotorNoiseDeNull()
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
                'cleanliness' => 'Clean',
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
                'noise_de' => null,
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
            ->assertSeeText('The noise de field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorNoiseDeInvalid()
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
                'cleanliness' => 'Clean',
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
                'noise_de' => 'Kasar',
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
            ->assertSeeText('The selected noise de is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION NDEV VALUE
    public function testPostRecordMotorVibrationNdeVerticalNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => null,
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


    public function testPostRecordMotorVibrationNdeVerticalInvalidDecimal()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => '10.2.1',
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
            ->assertSeeText('The vibration nde vertical value field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeVerticalInvalidMin()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => '-1',
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
            ->assertSeeText('The vibration nde vertical value field must be at least 0.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeVerticalInvalidMax()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => '45.01',
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
            ->assertSeeText('The vibration nde vertical value field must not be greater than 45.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION NDE VERTICAL DESC
    public function testPostRecordMotorVibrationNdeVerticalDescNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '1.80',
                'vibration_de_vertical_desc' => "Satisfactory",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => null,
                'vibration_nde_horizontal_value' => "4.50",
                'vibration_nde_horizontal_desc' => "Unsatisfactory",
                'vibration_nde_frame_value' => "45",
                'vibration_nde_frame_desc' => "Unacceptable",
                'noise_nde' => "Abnormal",
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde vertical desc field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeVerticalDescInvalid()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '1.80',
                'vibration_de_vertical_desc' => "Satisfactory",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => 'Lumayan',
                'vibration_nde_horizontal_value' => "4.50",
                'vibration_nde_horizontal_desc' => "Unsatisfactory",
                'vibration_nde_frame_value' => "45",
                'vibration_nde_frame_desc' => "Unacceptable",
                'noise_nde' => "Abnormal",
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected vibration nde vertical desc is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION NDEH VALUE
    public function testPostRecordMotorVibrationNdeHorizontalNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => "Satisfactory",
                'vibration_nde_horizontal_value' => null,
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

    public function testPostRecordMotorVibrationNdeHorizontalInvalidDecimal()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => "Satisfactory",
                'vibration_nde_horizontal_value' => '10.2.1',
                'vibration_nde_horizontal_desc' => "Unsatisfactory",
                'vibration_nde_frame_value' => "45",
                'vibration_nde_frame_desc' => "Unacceptable",
                'noise_nde' => "Abnormal",
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde horizontal value field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeHorizontalInvalidMin()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => "Satisfactory",
                'vibration_nde_horizontal_value' => '-1',
                'vibration_nde_horizontal_desc' => "Unsatisfactory",
                'vibration_nde_frame_value' => "45",
                'vibration_nde_frame_desc' => "Unacceptable",
                'noise_nde' => "Abnormal",
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde horizontal value field must be at least 0.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeHorizontalInvalidMax()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => "Satisfactory",
                'vibration_nde_horizontal_value' => '45.01',
                'vibration_nde_horizontal_desc' => "Unsatisfactory",
                'vibration_nde_frame_value' => "45",
                'vibration_nde_frame_desc' => "Unacceptable",
                'noise_nde' => "Abnormal",
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde horizontal value field must not be greater than 45.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DE HORIZONTAL DESC
    public function testPostRecordMotorVibrationNdeHorizontalDescNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '1.80',
                'vibration_de_vertical_desc' => "Satisfactory",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => "Unsatisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => "Satisfactory",
                'vibration_nde_horizontal_value' => "4.50",
                'vibration_nde_horizontal_desc' => null,
                'vibration_nde_frame_value' => "45",
                'vibration_nde_frame_desc' => "Unacceptable",
                'noise_nde' => "Abnormal",
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde horizontal desc field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeHorizontalDescInvalid()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '1.80',
                'vibration_de_vertical_desc' => "Satisfactory",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => "Unsatisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => "Satisfactory",
                'vibration_nde_horizontal_value' => "4.50",
                'vibration_nde_horizontal_desc' => 'Lumayan',
                'vibration_nde_frame_value' => "45",
                'vibration_nde_frame_desc' => "Unacceptable",
                'noise_nde' => "Abnormal",
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected vibration nde horizontal desc is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION NDEF VALUE
    public function testPostRecordMotorVibrationNdeFrameNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "45",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => "Satisfactory",
                'vibration_nde_horizontal_value' => "4.50",
                'vibration_nde_horizontal_desc' => "Unsatisfactory",
                'vibration_nde_frame_value' => null,
                'vibration_nde_frame_desc' => "Unacceptable",
                'noise_nde' => "Abnormal",
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeFrameInvalidDecimal()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "45",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => "Satisfactory",
                'vibration_nde_horizontal_value' => "4.50",
                'vibration_nde_horizontal_desc' => "Unsatisfactory",
                'vibration_nde_frame_value' => '10.2.1',
                'vibration_nde_frame_desc' => "Unacceptable",
                'noise_nde' => "Abnormal",
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde frame value field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeFrameInvalidMin()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "45",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => "Satisfactory",
                'vibration_nde_horizontal_value' => "4.50",
                'vibration_nde_horizontal_desc' => "Unsatisfactory",
                'vibration_nde_frame_value' => '-1',
                'vibration_nde_frame_desc' => "Unacceptable",
                'noise_nde' => "Abnormal",
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde frame value field must be at least 0.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeFrameInvalidMax()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => "1.80",
                'vibration_de_vertical_desc' => "Good",
                'vibration_de_horizontal_value' => "4.50",
                'vibration_de_horizontal_desc' => "Satisfactory",
                'vibration_de_axial_value' => "45",
                'vibration_de_axial_desc' => "Unsatisfactory",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => "Satisfactory",
                'vibration_nde_horizontal_value' => "4.50",
                'vibration_nde_horizontal_desc' => "Unsatisfactory",
                'vibration_nde_frame_value' => '45.01',
                'vibration_nde_frame_desc' => "Unacceptable",
                'noise_nde' => "Abnormal",
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde frame value field must not be greater than 45.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION NDE FRAME DESC
    public function testPostRecordMotorVibrationNdeFrameDescNull()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '1.80',
                'vibration_de_vertical_desc' => "Satisfactory",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => "Unsatisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unacceptable",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => "Satisfactory",
                'vibration_nde_horizontal_value' => "4.50",
                'vibration_nde_horizontal_desc' => "Unsatisfactory",
                'vibration_nde_frame_value' => "45",
                'vibration_nde_frame_desc' => null,
                'noise_nde' => "Abnormal",
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde frame desc field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeFrameDescInvalid()
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
                'cleanliness' => 'Dirty',
                'nipple_grease' => 'Available',
                'number_of_greasing' => '255',
                'temperature_de' => "30.09",
                'temperature_body' => "30.09",
                'temperature_nde' => '30.10',
                'vibration_de_vertical_value' => '1.80',
                'vibration_de_vertical_desc' => "Satisfactory",
                'vibration_de_horizontal_value' => "1.80",
                'vibration_de_horizontal_desc' => "Unsatisfactory",
                'vibration_de_axial_value' => "4.50",
                'vibration_de_axial_desc' => "Unacceptable",
                'vibration_de_frame_value' => "45",
                'vibration_de_frame_desc' => "Unacceptable",
                'noise_de' => "Normal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => "Satisfactory",
                'vibration_nde_horizontal_value' => "4.50",
                'vibration_nde_horizontal_desc' => "Unsatisfactory",
                'vibration_nde_frame_value' => "45",
                'vibration_nde_frame_desc' => 'Lumayan',
                'noise_nde' => "Abnormal",
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected vibration nde frame desc is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // NOISE NDE
    public function testPostRecordMotorNoiseNdeNull()
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
                'cleanliness' => 'Clean',
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
                'noise_de' => "Abnormal",
                'vibration_nde_vertical_value' => "1.80",
                'vibration_nde_vertical_desc' => "Satisfactory",
                'vibration_nde_horizontal_value' => "4.50",
                'vibration_nde_horizontal_desc' => "Unsatisfactory",
                'vibration_nde_frame_value' => "45",
                'vibration_nde_frame_desc' => "Unacceptable",
                'noise_nde' => null,
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The noise nde field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorNoiseNdeInvalid()
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
                'cleanliness' => 'Clean',
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
                'noise_nde' => 'Kasar',
                'nik' => "55000154",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected noise nde is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }
}
