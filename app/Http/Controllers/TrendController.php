<?php

namespace App\Http\Controllers;

use App\Models\Finding;
use App\Services\MotorService;
use App\Services\TrafoService;
use App\Traits\Utility;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TrendController extends Controller
{
    use Utility;
    private MotorService $motorService;
    private TrafoService $trafoService;

    public function __construct(MotorService $motorService, TrafoService $trafoService)
    {
        $this->motorService = $motorService;
        $this->trafoService = $trafoService;
    }

    public function equipmentTrend(string $equipment, string $start_date = null, string $end_date = null)
    {
        $equipment_code = $this->getEquipmentCode($equipment);
        $start_date = !is_null($start_date) ? $start_date : Carbon::now()->addYears(-1)->addDays(-1);
        $end_date = !is_null($end_date) ? $end_date : Carbon::now()->addDays(1);

        if (in_array($equipment_code, $this->motorService->motorCodes()) && in_array($equipment, $this->motorService->registeredMotors())) {

            // MOTOR
            $collection = collect([
                'equipment' => $equipment,
                'table' => 'motor_records',
                'type' => 'motor',
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);

            // FNDING
            $findings = $this->queryFinding($equipment);
            $trends = $this->queryTrend($collection);

            Log::info("trend motor $equipment [$start_date - $end_date] viewed by user", ['user' => Auth::user()->fullname]);
            return response()->view('maintenance.trends.motor', [
                'table' => 'motor',
                'motorService' => $this->motorService,
                'equipment' => $equipment,
                'title' => 'Equipment trend',
                'created_at' => $this->getValueOf($trends, 'created_at'),
                'temperature_de' => $this->getValueOf($trends, 'temperature_de'),
                'temperature_body' => $this->getValueOf($trends, 'temperature_body'),
                'temperature_nde' => $this->getValueOf($trends, 'temperature_nde'),
                'motor_status' => $this->getValueOf($trends, 'motor_status')->map(function ($value, $key) {
                    if ($value == 'Running') {
                        return 'Run';
                    } else {
                        return 'Stop';
                    }
                }),
                'vibration_de_vertical_value' => $this->getValueOf($trends, 'vibration_de_vertical_value'),
                'vibration_de_horizontal_value' => $this->getValueOf($trends, 'vibration_de_horizontal_value'),
                'vibration_de_axial_value' => $this->getValueOf($trends, 'vibration_de_axial_value'),
                'vibration_de_frame_value' => $this->getValueOf($trends, 'vibration_de_frame_value'),
                'noise_de' => $this->getValueOf($trends, 'noise_de')->map(function ($value, $key) {
                    if ($value == 'Normal') {
                        return 'Good';
                    } else {
                        return 'Noisy';
                    }
                }),
                'vibration_nde_vertical_value' => $this->getValueOf($trends, 'vibration_nde_vertical_value'),
                'vibration_nde_horizontal_value' => $this->getValueOf($trends, 'vibration_nde_horizontal_value'),
                'vibration_nde_frame_value' => $this->getValueOf($trends, 'vibration_nde_frame_value'),
                'noise_nde' => $this->getValueOf($trends, 'noise_de')->map(function ($value, $key) {
                    if ($value == 'Normal') {
                        return 'Good';
                    } else {
                        return 'Noisy';
                    }
                }),
                'number_of_greasing' => $this->getValueOf($trends, 'number_of_greasing'),
                'nik' => $this->getValueOf($trends, 'nik'),
                'findings' => $findings,
            ]);
        } else if (in_array($equipment_code, ['ETF'])) {

            // TRAFO
            $collection = collect([
                'equipment' => $equipment,
                'table' => 'trafo_records',
                'type' => 'trafo',
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);

            // FNDING
            $findings = $this->queryFinding($equipment);
            $trends = $this->queryTrend($collection);

            Log::info("trend trafo $equipment [$start_date - $end_date] viewed by user", ['user' => Auth::user()->fullname]);
            return response()->view('maintenance.trends.trafo', [
                'table' => 'trafo',
                'trafoService' => $this->trafoService,
                'equipment' => $equipment,
                'title' => 'Equipment trend',
                'created_at' => $this->getValueOf($trends, 'created_at'),
                'trafo_status' => $this->getValueOf($trends, 'trafo_status'),
                'primary_current_phase_r' => $this->getValueOf($trends, 'primary_current_phase_r'),
                'primary_current_phase_s' => $this->getValueOf($trends, 'primary_current_phase_s'),
                'primary_current_phase_t' => $this->getValueOf($trends, 'primary_current_phase_t'),
                'secondary_current_phase_r' => $this->getValueOf($trends, 'secondary_current_phase_r'),
                'secondary_current_phase_s' => $this->getValueOf($trends, 'secondary_current_phase_s'),
                'secondary_current_phase_t' => $this->getValueOf($trends, 'secondary_current_phase_t'),
                'primary_voltage' => $this->getValueOf($trends, 'primary_voltage'),
                'secondary_voltage' => $this->getValueOf($trends, 'secondary_voltage'),
                'oil_temperature' => $this->getValueOf($trends, 'oil_temperature'),
                'winding_temperature' => $this->getValueOf($trends, 'winding_temperature'),
                'cleanliness' => $this->getValueOf($trends, 'cleanliness'),
                'noise' => $this->getValueOf($trends, 'noise'),
                'silica_gel' => $this->getValueOf($trends, 'silica_gel'),
                'earthing_connection' => $this->getValueOf($trends, 'earthing_connection'),
                'oil_leakage' => $this->getValueOf($trends, 'oil_leakage'),
                'oil_level' => $this->getValueOf($trends, 'oil_level'),
                'blower_condition' => $this->getValueOf($trends, 'blower_condition'),
                'nik' => $this->getValueOf($trends, 'nik'),
                'findings' => $findings,
            ]);
        } else {
            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The $equipment trend is not found."]);
        }
    }

    public function queryTrend(Collection $collection)
    {
        $trends = DB::table($collection->get('table'))
            ->where($collection->get('type'), '=', $collection->get('equipment'))
            ->whereBetween('created_at', [$collection->get('start_date'), $collection->get('end_date')])
            ->get();

        return $trends;
    }

    public function queryFinding(string $equipment)
    {
        $findings = DB::table('findings')
            ->select(['description', 'image', 'reporter', 'created_at'])
            ->where('equipment', '=', $equipment)
            ->orderBy('created_at', 'desc')
            ->get();

        return $findings;
    }

    public function trends()
    {
        return response()->view('maintenance.trends.trends', [
            'title' => 'Equipment trends'
        ]);
    }

    public function getTrends(Request $request)
    {
        $request->mergeIfMissing(['generate_pdf' => 'false']);

        $data = [
            'equipment' => $request->input('equipment'),
            'start_date' => $request->input('start_date') ?? Carbon::now()->addYears(-1)->addDays(-1),
            'end_date' => $request->input('end_date') ?? Carbon::now()->addDays(1),
            'generate_pdf' => $request->input('generate_pdf'),
        ];

        $rules = [
            'equipment' => ['required', Rule::in(array_merge($this->motorService->registeredMotors(), $this->trafoService->registeredTrafos()))],
            'start_date' => ['required', 'before:now'],
            'end_date' => ['required', 'after:start_date'],
            'generate_pdf' => ['required'],
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {

            $validated = $validator->validated();
            $start_date = Carbon::create($validated['start_date'])->format('Y-m-d');
            $end_date = Carbon::create($validated['end_date'])->format('Y-m-d');

            if ($validated['generate_pdf'] == 'true') {

                $equipment = $validated['equipment'];
                $equipment_code = $this->getEquipmentCode($equipment);

                // CHECK TYPE OF EQUIPMENT
                if (in_array($equipment_code, $this->motorService->motorCodes()) && in_array($equipment, $this->motorService->registeredMotors())) {

                    Log::info("pdf trend motor $equipment [$start_date - $end_date] generated by user", ['user' => Auth::user()->fullname]);
                    return redirect()->action([PdfController::class, 'reportEquipmentPdf'], [
                        'type' => 'motors',
                        'equipment' => $equipment,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                    ]);
                } else {

                    Log::info("pdf trend trafo $equipment [$start_date - $end_date] generated by user", ['user' => Auth::user()->fullname]);
                    return redirect()->action([PdfController::class, 'reportEquipmentPdf'], [
                        'type' => 'trafos',
                        'equipment' => $equipment,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                    ]);
                }
            } else {
                return $this->equipmentTrend($validated['equipment'], $start_date, $end_date);
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}
