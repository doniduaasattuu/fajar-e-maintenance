<?php

namespace Tests\Feature;

use App\Models\Finding;
use App\Models\TrafoRecord;
use Carbon\Carbon;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\TrafoDetailsSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserRoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TrafoRecordControllerTest extends TestCase
{
    public function clearFindingImages()
    {
        $files = new Filesystem();
        $files->cleanDirectory('storage/app/public/findings');
    }

    public function testGetCheckingFormTrafoInvalid()
    {
        $this->seed([UserSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this->get('/scanner');

        $this->followingRedirects()
            ->get('/checking-form/Fajar-TrafoListI12')
            ->assertSeeText('[404] Not found')
            ->assertSeeText('The equipment was not found.');
    }

    public function testGetCheckingValidSuccess()
    {
        $this->seed([UserSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this->get('/checking-form/Fajar-TrafoList1')
            ->assertSeeText('FP-01-IN1')
            ->assertSeeText('ETF000085')
            ->assertSeeText('Trafo status')
            ->assertSee('Online')
            ->assertSee('Offline')
            ->assertSeeText('Primary current')
            ->assertSeeText('Secondary current')
            ->assertSee('Phase R')
            ->assertSee('Phase S')
            ->assertSee('Phase T')
            ->assertSeeText('Primary voltage')
            ->assertSeeText('Secondary voltage')
            ->assertSeeText('Oil temperature')
            ->assertSeeText('Winding temperature')
            ->assertSee('°C')
            ->assertSeeText('Cleanliness')
            ->assertSee('Clean')
            ->assertSee('Dirty')
            ->assertSeeText('Noise')
            ->assertSee('Normal')
            ->assertSee('Abnormal')
            ->assertSeeText('Silica gel')
            ->assertSee('Good')
            ->assertSee('Satisfactory')
            ->assertSee('Unsatisfactory')
            ->assertSee('Unacceptable')
            ->assertSeeText('Earthing connection')
            ->assertSee('No loose')
            ->assertSee('Loose')
            ->assertSeeText('Oil leakage')
            ->assertSee('No leaks')
            ->assertSee('Leaks')
            ->assertSeeText('Oil level')
            ->assertSee('%')
            ->assertSeeText('Blower condition')
            ->assertSee('Good')
            ->assertSee('Not good')
            ->assertSeeText('Finding')
            ->assertSee('Description of findings if any')
            ->assertSeeText('Finding image')
            ->assertSee('Submit');
    }

    // POST
    public function testPostRecordTrafoSuccess()
    {
        $this->seed([UserSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');

        $records = TrafoRecord::query()->get();
        self::assertCount(1, $records);
    }

    // FUNCLOC
    public function testPostRecordTrafoFunclocNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);
        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => null,
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The funcloc field is required.');
    }

    public function testPostRecordTrafoFunclocInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);
        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1-TRF-ENC',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The selected funcloc is invalid.');
    }

    // ID TRAFO NULL
    public function testPostRecordTrafoIdTrafoNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);
        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => null,
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo field is required.');
    }

    public function testPostRecordTrafoIdTrafoInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000231',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The selected trafo is invalid.');
    }

    // SORT FIELD
    public function testPostRecordTrafoSortFieldNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => null,
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The sort field field is required.');
    }

    // TRAFO STATUS
    public function testPostRecordTrafoTrafoStatusNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => null,
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo status field is required.');
    }

    public function testPostRecordTrafoTrafoStatusInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Running',
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The selected trafo status is invalid.');
    }

    public function testPostRecordTrafoTrafoStatusOnlineSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    public function testPostRecordTrafoTrafoStatusOfflineSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Offline',
                'primary_current_phase_r' => null,
                'primary_current_phase_s' => null,
                'primary_current_phase_t' => null,
                'secondary_current_phase_r' => null,
                'secondary_current_phase_s' => null,
                'secondary_current_phase_t' => null,
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    public function testPostRecordTrafoTrafoStatusOfflineFailed()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Offline',
                'primary_current_phase_r' => '45.4',
                'primary_current_phase_s' => '45.8',
                'primary_current_phase_t' => '45.2',
                'secondary_current_phase_r' => '102.43',
                'secondary_current_phase_s' => '103.13',
                'secondary_current_phase_t' => '102.63',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The primary current phase r field is prohibited when trafo status is Offline.')
            ->assertSeeText('The primary current phase s field is prohibited when trafo status is Offline.')
            ->assertSeeText('The primary current phase t field is prohibited when trafo status is Offline.')
            ->assertSeeText('The secondary current phase r field is prohibited when trafo status is Offline.')
            ->assertSeeText('The secondary current phase s field is prohibited when trafo status is Offline.')
            ->assertSeeText('The secondary current phase t field is prohibited when trafo status is Offline.');
    }

    // PRIMARY CURRENT
    public function testPostRecordTrafoPrimaryCurrentNullSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => null,
                'primary_current_phase_s' => null,
                'primary_current_phase_t' => null,
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    // PRIMARY CURRENT
    public function testPostRecordTrafoPrimaryCurrentInvalidMaxLength()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '999999',
                'primary_current_phase_s' => '999999',
                'primary_current_phase_t' => '999999',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The primary current phase r field must not be greater than 99999.')
            ->assertSeeText('The primary current phase s field must not be greater than 99999.')
            ->assertSeeText('The primary current phase t field must not be greater than 99999.');
    }

    public function testPostRecordTrafoPrimaryCurrentInvalidDecimal()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '99999..9',
                'primary_current_phase_s' => '99999..9',
                'primary_current_phase_t' => '99999..9',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The primary current phase r field must have 0-2 decimal places.')
            ->assertSeeText('The primary current phase s field must have 0-2 decimal places.')
            ->assertSeeText('The primary current phase t field must have 0-2 decimal places.');
    }

    public function testPostRecordTrafoPrimaryCurrentInvalidMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '-1',
                'primary_current_phase_s' => '-1',
                'primary_current_phase_t' => '-1',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The primary current phase r field must be at least 0.')
            ->assertSeeText('The primary current phase s field must be at least 0.')
            ->assertSeeText('The primary current phase t field must be at least 0.');
    }

    public function testPostRecordTrafoPrimaryCurrentInvalidMaxValue()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '999999',
                'primary_current_phase_s' => '999999',
                'primary_current_phase_t' => '999999',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The primary current phase r field must not be greater than 99999.')
            ->assertSeeText('The primary current phase s field must not be greater than 99999.')
            ->assertSeeText('The primary current phase t field must not be greater than 99999.');
    }

    // SECONDARY CURRENT
    public function testPostRecordTrafoSecondaryCurrentInvalidMaxLength()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.5',
                'primary_current_phase_s' => '65.5',
                'primary_current_phase_t' => '65.5',
                'secondary_current_phase_r' => '999999',
                'secondary_current_phase_s' => '999999',
                'secondary_current_phase_t' => '999999',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The secondary current phase r field must not be greater than 99999.')
            ->assertSeeText('The secondary current phase s field must not be greater than 99999.')
            ->assertSeeText('The secondary current phase t field must not be greater than 99999.');
    }

    public function testPostRecordTrafoSecondaryCurrentInvalidDecimal()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.2',
                'primary_current_phase_s' => '65.2',
                'primary_current_phase_t' => '65.2',
                'secondary_current_phase_r' => '99999..9',
                'secondary_current_phase_s' => '99999..9',
                'secondary_current_phase_t' => '99999..9',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The secondary current phase r field must have 0-2 decimal places.')
            ->assertSeeText('The secondary current phase s field must have 0-2 decimal places.')
            ->assertSeeText('The secondary current phase t field must have 0-2 decimal places.');
    }

    public function testPostRecordTrafoSecondaryCurrentInvalidMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.2',
                'primary_current_phase_s' => '65.2',
                'primary_current_phase_t' => '65.2',
                'secondary_current_phase_r' => '-1',
                'secondary_current_phase_s' => '-1',
                'secondary_current_phase_t' => '-1',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The secondary current phase r field must be at least 0.')
            ->assertSeeText('The secondary current phase s field must be at least 0.')
            ->assertSeeText('The secondary current phase t field must be at least 0.');
    }

    public function testPostRecordTrafoSecondaryCurrentInvalidMaxValue()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '999999',
                'secondary_current_phase_s' => '999999',
                'secondary_current_phase_t' => '999999',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The secondary current phase r field must not be greater than 99999.')
            ->assertSeeText('The secondary current phase s field must not be greater than 99999.')
            ->assertSeeText('The secondary current phase t field must not be greater than 99999.');
    }

    // PRIMARY VOLTAGE
    public function testPostRecordTrafoPrimaryVoltageNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.5',
                'primary_current_phase_s' => '65.5',
                'primary_current_phase_t' => '65.5',
                'secondary_current_phase_r' => '652.12',
                'secondary_current_phase_s' => '652.12',
                'secondary_current_phase_t' => '652.12',
                'primary_voltage' => null,
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    public function testPostRecordTrafoPrimaryVoltageInvalidMaxLength()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.5',
                'primary_current_phase_s' => '65.5',
                'primary_current_phase_t' => '65.5',
                'secondary_current_phase_r' => '652.12',
                'secondary_current_phase_s' => '652.12',
                'secondary_current_phase_t' => '652.12',
                'primary_voltage' => '9999999',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The primary voltage field must not be greater than 999999.');
    }

    public function testPostRecordTrafoPrimaryVoltageInvalidDecimal()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.2',
                'primary_current_phase_s' => '65.2',
                'primary_current_phase_t' => '65.2',
                'secondary_current_phase_r' => '455.20',
                'secondary_current_phase_s' => '455.20',
                'secondary_current_phase_t' => '455.20',
                'primary_voltage' => '9999..12',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The primary voltage field must have 0-2 decimal places.');
    }

    public function testPostRecordTrafoPrimaryVoltageInvalidMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.2',
                'primary_current_phase_s' => '65.2',
                'primary_current_phase_t' => '65.2',
                'secondary_current_phase_r' => '450.23',
                'secondary_current_phase_s' => '450.23',
                'secondary_current_phase_t' => '450.23',
                'primary_voltage' => '-1',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The primary voltage field must be at least 0.');
    }

    public function testPostRecordTrafoPrimaryVoltageInvalidMaxValue()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '9999999',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The primary voltage field must not be greater than 999999.');
    }

    // SECONDARY VOLTAGE
    public function testPostRecordTrafoSecondaryVoltageNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.5',
                'primary_current_phase_s' => '65.5',
                'primary_current_phase_t' => '65.5',
                'secondary_current_phase_r' => '652.12',
                'secondary_current_phase_s' => '652.12',
                'secondary_current_phase_t' => '652.12',
                'primary_voltage' => '20000',
                'secondary_voltage' => null,
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    public function testPostRecordTrafoSecondaryVoltageInvalidMaxLength()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.5',
                'primary_current_phase_s' => '65.5',
                'primary_current_phase_t' => '65.5',
                'secondary_current_phase_r' => '652.12',
                'secondary_current_phase_s' => '652.12',
                'secondary_current_phase_t' => '652.12',
                'primary_voltage' => '20000',
                'secondary_voltage' => '9999999',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The secondary voltage field must not be greater than 999999.');
    }

    public function testPostRecordTrafoSecondaryVoltageInvalidDecimal()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.2',
                'primary_current_phase_s' => '65.2',
                'primary_current_phase_t' => '65.2',
                'secondary_current_phase_r' => '455.20',
                'secondary_current_phase_s' => '455.20',
                'secondary_current_phase_t' => '455.20',
                'primary_voltage' => '20000',
                'secondary_voltage' => '9999..12',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The secondary voltage field must have 0-2 decimal places.');
    }

    public function testPostRecordTrafoSecondaryVoltageInvalidMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.2',
                'primary_current_phase_s' => '65.2',
                'primary_current_phase_t' => '65.2',
                'secondary_current_phase_r' => '450.23',
                'secondary_current_phase_s' => '450.23',
                'secondary_current_phase_t' => '450.23',
                'primary_voltage' => '20000',
                'secondary_voltage' => '-1',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The secondary voltage field must be at least 0.');
    }

    public function testPostRecordTrafoSecondaryVoltageInvalidMaxValue()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '9999999',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The secondary voltage field must not be greater than 999999.');
    }

    // OIL TEMPERATURE
    public function testPostRecordTrafoOilTemperatureNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.5',
                'primary_current_phase_s' => '65.5',
                'primary_current_phase_t' => '65.5',
                'secondary_current_phase_r' => '652.12',
                'secondary_current_phase_s' => '652.12',
                'secondary_current_phase_t' => '652.12',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => null,
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    public function testPostRecordTrafoOilTemperatureInvalidMaxLength()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.5',
                'primary_current_phase_s' => '65.5',
                'primary_current_phase_t' => '65.5',
                'secondary_current_phase_r' => '652.12',
                'secondary_current_phase_s' => '652.12',
                'secondary_current_phase_t' => '652.12',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '01111',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The oil temperature field must not be greater than 255.');
    }

    public function testPostRecordTrafoOilTemperatureInvalidDecimal()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.2',
                'primary_current_phase_s' => '65.2',
                'primary_current_phase_t' => '65.2',
                'secondary_current_phase_r' => '455.20',
                'secondary_current_phase_s' => '455.20',
                'secondary_current_phase_t' => '455.20',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '9999..12',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The oil temperature field must have 0-2 decimal places.');
    }

    public function testPostRecordTrafoOilTemperatureInvalidMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.2',
                'primary_current_phase_s' => '65.2',
                'primary_current_phase_t' => '65.2',
                'secondary_current_phase_r' => '450.23',
                'secondary_current_phase_s' => '450.23',
                'secondary_current_phase_t' => '450.23',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '14',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The oil temperature field must be at least 15.');
    }

    public function testPostRecordTrafoOilTemperatureInvalidMaxValue()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '255.01',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The oil temperature field must not be greater than 255.');
    }

    // WINDING TEMPERATURE
    public function testPostRecordTrafoWindingTemperatureNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.5',
                'primary_current_phase_s' => '65.5',
                'primary_current_phase_t' => '65.5',
                'secondary_current_phase_r' => '652.12',
                'secondary_current_phase_s' => '652.12',
                'secondary_current_phase_t' => '652.12',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '35.6',
                'winding_temperature' => null,
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    public function testPostRecordTrafoWindingTemperatureInvalidMaxLength()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.5',
                'primary_current_phase_s' => '65.5',
                'primary_current_phase_t' => '65.5',
                'secondary_current_phase_r' => '652.12',
                'secondary_current_phase_s' => '652.12',
                'secondary_current_phase_t' => '652.12',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '42.10',
                'winding_temperature' => '01111',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The winding temperature field must not be greater than 255.');
    }

    public function testPostRecordTrafoWindingTemperatureInvalidDecimal()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.2',
                'primary_current_phase_s' => '65.2',
                'primary_current_phase_t' => '65.2',
                'secondary_current_phase_r' => '455.20',
                'secondary_current_phase_s' => '455.20',
                'secondary_current_phase_t' => '455.20',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '42',
                'winding_temperature' => '9999..12',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The winding temperature field must have 0-2 decimal places.');
    }

    public function testPostRecordTrafoWindingTemperatureInvalidMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '65.2',
                'primary_current_phase_s' => '65.2',
                'primary_current_phase_t' => '65.2',
                'secondary_current_phase_r' => '450.23',
                'secondary_current_phase_s' => '450.23',
                'secondary_current_phase_t' => '450.23',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '32.01',
                'winding_temperature' => '14',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The winding temperature field must be at least 15.');
    }

    public function testPostRecordTrafoWindingTemperatureInvalidMaxValue()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '255.01',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The winding temperature field must not be greater than 255.');
    }

    // CLEANLINESS
    public function testPostRecordTrafoCleanlinessNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => null,
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The cleanliness field is required.');
    }

    public function testPostRecordTrafoCleanlinessInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Lumayan',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The selected cleanliness is invalid.');
    }

    public function testPostRecordTrafoCleanlinessCleanSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    public function testPostRecordTrafoCleanlinessDirtySuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Dirty',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    // NOISE
    public function testPostRecordTrafoNoiseNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => null,
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The noise field is required.');
    }

    public function testPostRecordTrafoNoiseInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => 'Not bad',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The selected noise is invalid.');
    }

    public function testPostRecordTrafoNoiseNormalSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    public function testPostRecordTrafoNoiseAbnormalSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Dirty',
                'noise' => 'Abnormal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    // SILICA GEL
    public function testPostRecordTrafoSilicaGelNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => null,
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The silica gel field is required.');
    }

    public function testPostRecordTrafoSilicaGelInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Light brown',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The selected silica gel is invalid.');
    }

    public function testPostRecordTrafoSilicaGelGoodSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    public function testPostRecordTrafoSilicaGelSatisfactorySuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Dirty',
                'noise' => 'Abnormal',
                'silica_gel' => 'Satisfactory',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    public function testPostRecordTrafoSilicaGelUnsatisfactorySuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Dirty',
                'noise' => 'Normal',
                'silica_gel' => 'Unsatisfactory',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    public function testPostRecordTrafoSilicaGelUnacceptableSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Dirty',
                'noise' => 'Normal',
                'silica_gel' => 'Unacceptable',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    // EARTHING CONNECTION
    public function testPostRecordTrafoEarthingConnectionNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => null,
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The earthing connection field is required.');
    }

    public function testPostRecordTrafoEarthingConnectionInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Pink',
                'earthing_connection' => 'Kendor',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The selected earthing connection is invalid.');
    }

    public function testPostRecordTrafoEarthingConnectionNoLooseSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    public function testPostRecordTrafoEarthingConnectionLooseSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Dirty',
                'noise' => 'Abnormal',
                'silica_gel' => 'Unacceptable',
                'earthing_connection' => 'Loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    // OIL LEAKAGE
    public function testPostRecordTrafoOilLeakageNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'Loose',
                'oil_leakage' => null,
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The oil leakage field is required.');
    }

    public function testPostRecordTrafoOilLeakageInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Pink',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leak',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The selected oil leakage is invalid.');
    }

    public function testPostRecordTrafoOilLeakageNoLooseSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    public function testPostRecordTrafoOilLeakageLooseSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Dirty',
                'noise' => 'Abnormal',
                'silica_gel' => 'Unacceptable',
                'earthing_connection' => 'Loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    // OIL LEVEL
    public function testPostRecordTrafoOilLevelNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Dirty',
                'noise' => 'Abnormal',
                'silica_gel' => 'Unacceptable',
                'earthing_connection' => 'Loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => null,
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    public function testPostRecordTrafoOilLevelInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Dirty',
                'noise' => 'Abnormal',
                'silica_gel' => 'Unacceptable',
                'earthing_connection' => 'Loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '8O',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The oil level field must be a number.');
    }

    public function testPostRecordTrafoOilLevelInvalidMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Dirty',
                'noise' => 'Abnormal',
                'silica_gel' => 'Unacceptable',
                'earthing_connection' => 'Loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '-1',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The oil level field must be at least 0.');
    }

    public function testPostRecordTrafoOilLevelInvalidMax()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Dirty',
                'noise' => 'Abnormal',
                'silica_gel' => 'Unacceptable',
                'earthing_connection' => 'Loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '100.1',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The oil level field must not be greater than 100.');
    }

    // BLOWER CONDITION
    public function testPostRecordTrafoBlowerConditionNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => null,
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The blower condition field is required.');
    }

    public function testPostRecordTrafoBlowerConditionInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Pink',
                'earthing_connection' => 'Kendor',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Lepas',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The selected blower condition is invalid.');
    }

    public function testPostRecordTrafoBlowerConditionGoodSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    public function testPostRecordTrafoBlowerConditionNotGoodSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '63.24',
                'primary_current_phase_s' => '63.24',
                'primary_current_phase_t' => '63.24',
                'secondary_current_phase_r' => '452.22',
                'secondary_current_phase_s' => '452.22',
                'secondary_current_phase_t' => '452.22',
                'primary_voltage' => '20000',
                'secondary_voltage' => '400',
                'oil_temperature' => '69.0',
                'winding_temperature' => '45.2',
                'cleanliness' => 'Dirty',
                'noise' => 'Abnormal',
                'silica_gel' => 'Unacceptable',
                'earthing_connection' => 'Loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Not good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
            ])
            ->assertSeeText('The trafo record successfully saved.');
    }

    // =====================================================
    // ================== POST WITH IMAGE ==================
    // =====================================================
    public function testPostTrafoRecordWithTextAndImageSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $image = UploadedFile::fake()->image('photo.jpg');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => 'This is valid finding_description',
                'finding_image' => $image,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The trafo record successfully saved.');

        $findings = Finding::query()->get();
        $records = TrafoRecord::query()->get();
        self::assertCount(1, $findings);
        self::assertCount(1, $records);
        self::assertEquals($findings->first()->id, $records->first()->id);
        $this->clearFindingImages();
    }

    public function testPostTrafoRecordWithTextOnlySuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => 'This is valid finding description',
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The trafo record successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);

        $this->clearFindingImages();
    }

    public function testPostTrafoRecordWithoutTextAndImageSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The trafo record successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(0, $findings);

        $records = TrafoRecord::query()->get();
        self::assertNotNull($records);
        self::assertCount(1, $records);

        $this->clearFindingImages();
    }

    public function testPostTrafoRecordWithTextAndWithoutImageSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => 'This is valid description',
                'finding_image' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The trafo record successfully saved.');

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);

        $records = TrafoRecord::query()->get();
        self::assertNotNull($records);
        self::assertCount(1, $records);

        $this->clearFindingImages();
    }

    public function testPostTrafoRecordWithoutTextAndWithImageFailed()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $image = UploadedFile::fake()->image('photo.jpg');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => null,
                'finding_image' => $image,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The finding image field is prohibited when finding description is empty.')
            ->assertDontSeeText('The trafo record successfully saved.');

        $records = TrafoRecord::query()->get();
        self::assertCount(0, $records);

        $findings = Finding::query()->get();
        self::assertCount(0, $findings);

        $this->clearFindingImages();
    }

    public function testPostTrafoRecordWithTextAndImageFailedMaxSize()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $image = UploadedFile::fake()->create('photo', 5500, 'jpg');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => 'This is valid description finding',
                'finding_image' => $image,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The finding image field must not be greater than 5000 kilobytes.')
            ->assertDontSeeText('The trafo record successfully saved.');

        $records = TrafoRecord::query()->get();
        self::assertCount(0, $records);

        $findings = Finding::query()->get();
        self::assertCount(0, $findings);

        $this->clearFindingImages();
    }

    public function testPostTrafoRecordWithTextAndImageInvalidFormat()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/checking-form/Fajar-TrafoList1');

        $image = UploadedFile::fake()->create('photo', 2500, 'gif');

        $this->followingRedirects()
            ->post('/record-trafo', [
                'id' => uniqid(),
                'funcloc' => 'FP-01-IN1',
                'trafo' => 'ETF000085',
                'sort_field' => 'TRAFO PLN',
                'trafo_status' => 'Online',
                'primary_current_phase_r' => '45.25',
                'primary_current_phase_s' => '49.85',
                'primary_current_phase_t' => '44.58',
                'secondary_current_phase_r' => '654.8',
                'secondary_current_phase_s' => '684.23',
                'secondary_current_phase_t' => '652.71',
                'primary_voltage' => '20215',
                'secondary_voltage' => '401',
                'oil_temperature' => '38.5',
                'winding_temperature' => '48.5',
                'cleanliness' => 'Clean',
                'noise' => 'Normal',
                'silica_gel' => 'Good',
                'earthing_connection' => 'No loose',
                'oil_leakage' => 'No leaks',
                'oil_level' => '85',
                'blower_condition' => 'Good',
                'nik' => '55000154',
                'finding_description' => 'This is valid description finding',
                'finding_image' => $image,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ])
            ->assertSeeText('The finding image field must be a file of type: png, jpeg, jpg.')
            ->assertDontSeeText('The trafo record successfully saved.');

        $records = TrafoRecord::query()->get();
        self::assertCount(0, $records);

        $findings = Finding::query()->get();
        self::assertCount(0, $findings);

        $this->clearFindingImages();
    }

    // ===============================================
    // ================ EDIT RECORD ==================
    // ===============================================
    public function testGetEditRecordTrafo()
    {
        $this->testPostRecordTrafoSuccess();

        $records = TrafoRecord::query()->first();

        $id = $records->first()->id;

        $this->get("/record-edit/trafo/$id")
            ->assertSeeText('[ EDIT')
            ->assertSeeText('RECORD ]')
            ->assertSeeText('Maximum upload file size: 5 MB.')
            ->assertDontSeeText('Existing');
    }

    public function testGetEditRecordTrafoWithFinding()
    {
        $this->testPostTrafoRecordWithTextAndImageSuccess();

        $records = TrafoRecord::query()->get();
        self::assertNotNull($records);
        self::assertCount(1, $records);

        $findings = Finding::query()->get();
        self::assertNotNull($findings);
        self::assertCount(1, $findings);

        $id = $findings->first()->id;

        $this->get("/record-edit/trafo/$id")
            ->assertSeeText('[ EDIT')
            ->assertSeeText('RECORD ]')
            ->assertSeeText('Existing');
    }
}
