<?php

namespace App\Http\Controllers;

use App\Services\MotorService;
use App\Traits\Utility;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TrendController extends Controller
{
    use Utility;
    private MotorService $motorService;

    public function __construct(MotorService $motorService)
    {
        $this->motorService = $motorService;
    }

    public function equipmentTrend(string $equipment)
    {
        $equipment_code = $this->getEquipmentCode($equipment);
        $end_date = Carbon::now()->addDays(1);
        $start_date = Carbon::now()->addYears(-1)->addDays(-1);

        if (in_array($equipment_code, $this->motorService->motorCodes()) && in_array($equipment, $this->motorService->registeredMotors())) {

            // MOTOR
            $collection = collect([
                'equipment' => $equipment,
                'table' => 'motor_records',
                'type' => 'motor',
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);

            $trends = $this->queryTrend($collection);
            return response()->view('maintenance.trends.motor', [
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

            $trends = $this->queryTrend($collection);

            return redirect('/');
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
}
