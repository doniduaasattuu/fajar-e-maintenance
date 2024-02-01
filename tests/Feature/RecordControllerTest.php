<?php

namespace Tests\Feature;

use App\Models\Finding;
use App\Models\MotorRecord;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorDetailsSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class RecordControllerTest extends TestCase
{
    public function clearFindingImages()
    {
        $files = new Filesystem();
        $files->cleanDirectory('storage/app/public/findings');
    }

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
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
            ->assertSee('IEC 60085')
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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    // FUNCLOC
    public function testPostRecordMotorFunclocNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The funcloc field is required.');
    }


    public function testPostRecordMotorFunclocInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected funcloc is invalid.');
    }

    // ID MOTOR
    public function testPostRecordMotorIdMotorNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor field is required.');
    }

    public function testPostRecordMotorIdMotorInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected motor is invalid.');
    }

    // SORT FIELD
    public function testPostRecordMotorSortFieldNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The sort field field is required.');
    }

    // MOTOR STATUS
    public function testPostRecordMotorMotorStatusNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor status field is required.');
    }

    public function testPostRecordMotorMotorStatusInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected motor status is invalid.');
    }

    public function testPostRecordMotorMotorStatusRunningSucess()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorMotorStatusNotRunningSucess()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    // CLEANLINESS
    public function testPostRecordMotorCleanlinessNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The cleanliness field is required.');
    }

    public function testPostRecordMotorCleanlinessInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected cleanliness is invalid.');
    }

    public function testPostRecordMotorCleanlinessCleanSuccess()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorCleanlinessDirtySuccess()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    // NIPPLE GREASE
    public function testPostRecordMotorNippleGreaseNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The nipple grease field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorNippleGreaseInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected nipple grease is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorNippleGreaseAvailableSuccess()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorNippleGreaseNotAvailableSuccess()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    // NUMBER OF GREASING
    public function testPostRecordMotorNumberOfGreasingNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorNumberOfGreasingFilled()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The number of greasing field is prohibited when nipple grease is Not Available.');
    }

    public function testPostRecordMotorNumberOfGreasingInvalidMax()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The number of greasing field must not be greater than 255.');
    }

    public function testPostRecordMotorNumberOfGreasingInvalidType()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The number of greasing field must be an integer.');
    }

    public function testPostRecordMotorNumberOfGreasingInvalidTypeComa()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The number of greasing field must be an integer.');
    }

    public function testPostRecordMotorNumberOfGreasingSuccess()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertDontSeeText('The number of greasing field must be an integer.')
            ->assertSeeText('The motor record successfully saved.');
    }

    // TEMPERATURE DE
    public function testPostRecordMotorTemperatureDeNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorTemperatureDeInvalidDecimal()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The temperature de field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorTemperatureDeInvalidMin()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The temperature de field must be at least 15.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorTemperatureDeInvalidMax()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The temperature de field must not be greater than 255.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // TEMPERATURE BODY
    public function testPostRecordMotorTemperatureBodyNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorTemperatureBodyInvalidDecimal()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The temperature body field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorTemperatureBodyInvalidMin()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The temperature body field must be at least 15.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorTemperatureBodyInvalidMax()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The temperature body field must not be greater than 255.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // TEMPERATURE NDE
    public function testPostRecordMotorTemperatureNdeNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorTemperatureNdeInvalidDecimal()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The temperature nde field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorTemperatureNdeInvalidMin()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The temperature nde field must be at least 15.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorTemperatureNdeInvalidMax()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The temperature nde field must not be greater than 255.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DEV VALUE
    public function testPostRecordMotorVibrationDeVerticalNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeVerticalInvalidDecimal()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration de vertical value field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeVerticalInvalidMin()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration de vertical value field must be at least 0.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeVerticalInvalidMax()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration de vertical value field must not be greater than 45.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DE VERTICAL DESC
    public function testPostRecordMotorVibrationDeVerticalDescNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration de vertical desc field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeVerticalDescInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected vibration de vertical desc is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DEH VALUE
    public function testPostRecordMotorVibrationDeHorizontalNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeHorizontalInvalidDecimal()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration de horizontal value field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeHorizontalInvalidMin()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration de horizontal value field must be at least 0.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeHorizontalInvalidMax()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration de horizontal value field must not be greater than 45.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DE HORIZONTAL DESC
    public function testPostRecordMotorVibrationDeHorizontalDescNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration de horizontal desc field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeHorizontalDescInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected vibration de horizontal desc is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DEA VALUE
    public function testPostRecordMotorVibrationDeAxialNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeAxialInvalidDecimal()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration de axial value field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeAxialInvalidMin()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration de axial value field must not be greater than 45.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DE AXIAL DESC
    public function testPostRecordMotorVibrationDeAxialDescNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration de axial desc field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeAxialDescInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected vibration de axial desc is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DEF VALUE
    public function testPostRecordMotorVibrationDeFrameNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeFrameInvalidDecimal()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration de frame value field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeFrameInvalidMin()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration de frame value field must be at least 0.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeFrameInvalidMax()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration de frame value field must not be greater than 45.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DE FRAME DESC
    public function testPostRecordMotorVibrationDeFrameDescNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration de frame desc field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationDeFrameDescInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected vibration de frame desc is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // NOISE DE
    public function testPostRecordMotorNoiseDeNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The noise de field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorNoiseDeInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected noise de is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION NDEV VALUE
    public function testPostRecordMotorVibrationNdeVerticalNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }


    public function testPostRecordMotorVibrationNdeVerticalInvalidDecimal()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde vertical value field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeVerticalInvalidMin()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde vertical value field must be at least 0.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeVerticalInvalidMax()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde vertical value field must not be greater than 45.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION NDE VERTICAL DESC
    public function testPostRecordMotorVibrationNdeVerticalDescNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde vertical desc field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeVerticalDescInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected vibration nde vertical desc is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION NDEH VALUE
    public function testPostRecordMotorVibrationNdeHorizontalNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeHorizontalInvalidDecimal()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde horizontal value field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeHorizontalInvalidMin()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde horizontal value field must be at least 0.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeHorizontalInvalidMax()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde horizontal value field must not be greater than 45.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION DE HORIZONTAL DESC
    public function testPostRecordMotorVibrationNdeHorizontalDescNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde horizontal desc field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeHorizontalDescInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected vibration nde horizontal desc is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION NDEF VALUE
    public function testPostRecordMotorVibrationNdeFrameNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeFrameInvalidDecimal()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde frame value field must have 0-2 decimal places.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeFrameInvalidMin()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde frame value field must be at least 0.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeFrameInvalidMax()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde frame value field must not be greater than 45.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // VIBRATION NDE FRAME DESC
    public function testPostRecordMotorVibrationNdeFrameDescNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The vibration nde frame desc field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorVibrationNdeFrameDescInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected vibration nde frame desc is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // NOISE NDE
    public function testPostRecordMotorNoiseNdeNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The noise nde field is required.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    public function testPostRecordMotorNoiseNdeInvalid()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The selected noise nde is invalid.')
            ->assertDontSeeText('The motor record successfully saved.');
    }

    // =====================================================
    // ================== POST WITH IMAGE ==================
    // =====================================================
    public function testPostRecordWithTextAndImageSuccess()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/checking-form/Fajar-MotorList2100');

        $image = UploadedFile::fake()->image('photo.jpg');

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
                'finding_description' => 'This is valid finding_description',
                'finding_image' => $image,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');

        $findings = Finding::query()->get();
        self::assertCount(1, $findings);
        $this->clearFindingImages();
    }

    public function testPostRecordWithTextSuccess()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => 'This is valid finding_description',
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        $this->clearFindingImages();
    }

    public function testPostRecordWithoutTextAndImageSuccess()
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
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');

        $findings = Finding::query()->get();
        self::assertCount(2, $findings);
        $this->clearFindingImages();
    }

    public function testPostRecordWithTextAndWithoutImageSuccess()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

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
                'finding_description' => 'This is valid finding description',
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The motor record successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        $this->clearFindingImages();
    }

    public function testPostRecordWithoutTextAndWithImageFailed()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/checking-form/Fajar-MotorList2100');

        $image = UploadedFile::fake()->image('photo.jpg');

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
                'finding_description' => null,
                'finding_image' => $image,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The finding image field is prohibited when finding description is empty.')
            ->assertDontSeeText('The motor record successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        $this->clearFindingImages();
    }

    public function testPostRecordWithTextAndImageFailedMaxSize()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/checking-form/Fajar-MotorList2100');

        $image = UploadedFile::fake()->create('photo', 5500, 'jpg');

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
                'finding_description' => 'This is valid description finding',
                'finding_image' => $image,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The finding image field must not be greater than 5000 kilobytes.')
            ->assertDontSeeText('The motor record successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        $this->clearFindingImages();
    }

    public function testPostRecordWithTextAndImageInvalidFormat()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class, UserSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/checking-form/Fajar-MotorList2100');

        $image = UploadedFile::fake()->create('photo', 2500, 'gif');

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
                'finding_description' => 'This is valid description finding',
                'finding_image' => $image,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The finding image field must be a file of type: png, jpeg, jpg.')
            ->assertDontSeeText('The motor record successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        $this->clearFindingImages();
    }

    // ===============================================
    // ================== EDIT FUNCLOC =============== 
    // ===============================================

    public function testGetEditRecord()
    {
        $this->testPostRecordMotorSuccess();

        $records = MotorRecord::query()->get();
        self::assertNotNull($records);
        self::assertCount(37, $records);

        $id = $records->first()->id;

        $this->get("/record-edit/motor/$id")
            ->assertSeeText('Motor record edit')
            ->assertSeeText('Maximum upload file size: 5 MB.')
            ->assertDontSeeText('Existing');
    }

    public function testGetEditRecordWithFinding()
    {
        $this->testPostRecordWithTextAndImageSuccess();

        $records = MotorRecord::query()->get();
        self::assertNotNull($records);
        self::assertCount(1, $records);

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertNotNull($findings);

        $id = $findings->first()->id;

        $this->get("/record-edit/motor/$id")
            ->assertSeeText('Motor record edit')
            ->assertSeeText('Existing');
    }
}
