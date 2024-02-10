<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MotorRecord;
use App\Models\TrafoRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;

class PdfController extends Controller
{
    private $motor_selected_columns = [
        'motor',
        'funcloc',
        'motor_status',
        'number_of_greasing',
        'temperature_de',
        'temperature_body',
        'temperature_nde',
        'vibration_de_vertical_value',
        'vibration_de_horizontal_value',
        'vibration_de_axial_value',
        'vibration_de_frame_value',
        'noise_de',
        'vibration_nde_vertical_value',
        'vibration_nde_horizontal_value',
        'vibration_nde_frame_value',
        'noise_nde',
        'cleanliness',
        'nik',
        'created_at'
    ];

    private $trafo_selected_columns = [
        'trafo',
        'funcloc',
        'trafo_status',
        'primary_current_phase_r',
        'primary_current_phase_s',
        'primary_current_phase_t',
        'secondary_current_phase_r',
        'secondary_current_phase_s',
        'secondary_current_phase_t',
        'primary_voltage',
        'secondary_voltage',
        'oil_temperature',
        'winding_temperature',
        'noise',
        'silica_gel',
        'oil_leakage',
        'oil_level',
        'cleanliness',
        'nik',
        'created_at'
    ];

    // DAILY RECORD PAGE
    public function report()
    {
        return response()->view('maintenance.report.report', [
            'title' => 'Daily activity report'
        ]);
    }

    public function query($model, string $date, string $date_after, $selected_columns)
    {
        return $model::query()
            ->select($selected_columns)
            ->where('created_at', '>=', $date)
            ->where('created_at', '<', $date_after)
            ->get();
    }

    public function generateReport(Request $request)
    {

        $data = [
            'table' =>  $request->input('table'),
            'date' => $request->input('date') ?? Carbon::today()->toDateString(),
        ];

        $rules = [
            'table' => ['required', Rule::in(['motors', 'trafos'])],
            'date' => ['required'],
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {

            $validated = $validator->validated();
            $date =  Carbon::create($validated['date'])->toDateString();
            $date_after = Carbon::create($validated['date'])->addDay();

            switch ($validated['table']) {
                case 'motors':

                    $motor_records = $this->query(MotorRecord::class, $date, $date_after, $this->motor_selected_columns);
                    return $this->renderPdf($this->motor_selected_columns, $motor_records, 'maintenance.report.motor', 'Motor daily report', $date);
                    break;

                case 'trafos':

                    $trafo_records = $this->query(TrafoRecord::class, $date, $date_after, $this->trafo_selected_columns);
                    return $this->renderPdf($this->trafo_selected_columns, $trafo_records, 'maintenance.report.trafo', 'Trafo daily report', $date);
                    break;

                default:
                    return redirect()->back()->withErrors($validator)->withInput();
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function renderPdf(array $selected_columns, Collection $records, string $view, string $title, string $date)
    {
        $file_title =  'Fajar E-Maintenance' . ' - ' . $title . ' - ' . Carbon::create($date)->format('d M Y');

        $pdf = LaravelMpdf::loadView($view, [
            'title' => $file_title,
            'records' => $records,
            'selected_columns' => $selected_columns,
        ]);

        return $pdf->stream($file_title . '.pdf');
    }

    public function reportTrafoHtml()
    {
        $records = TrafoRecord::query()
            ->select($this->trafo_selected_columns)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->view('maintenance.report.trafo', [
            'title' => 'Daily report trafo',
            'records' => $records,
            'selected_columns' => $this->trafo_selected_columns,
        ]);
    }

    public function reportMotorHtml()
    {
        $records = motorRecord::query()
            ->select($this->motor_selected_columns)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->view('maintenance.report.motor', [
            'title' => 'Daily report motor',
            'records' => $records,
            'selected_columns' => $this->motor_selected_columns,
        ]);
    }

    public function reportMotorEquipment(string $equipment)
    {
        $view = 'maintenance.report.motor';
        $records = MotorRecord::query()->where('motor', $equipment)->get();
        $title = 'Record of ' . $equipment;

        $pdf = LaravelMpdf::loadView($view, [
            'title' => $title,
            'records' => $records,
            'selected_columns' => $this->motor_selected_columns,
        ]);

        return $pdf->stream($title . '.pdf');
    }
}
