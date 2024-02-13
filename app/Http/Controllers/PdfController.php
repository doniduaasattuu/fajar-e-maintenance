<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MotorRecord;
use App\Models\TrafoRecord;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use Mpdf\Mpdf;

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

    public function html(string $view, string $title, Collection $records, array $selected_columns): Response
    {
        $html = response()->view($view, [
            'title' => $title,
            'records' => $records,
            'selected_columns' => $selected_columns,
        ]);

        return $html;
    }

    public function renderPdf(Response $html, string $title)
    {
        $pdf = new Mpdf(config('pdf'));
        $pdf->WriteHTML($html);
        $pdf->Output($title . '.pdf', 'I');
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

            try {
                switch ($validated['table']) {
                    case 'motors':

                        $view = 'maintenance.report.motor';
                        $motor_records = $this->query(MotorRecord::class, $date, $date_after, $this->motor_selected_columns);
                        $title = 'Fajar E-Maintenance' . ' - ' . 'Motor daily report' . ' - ' . Carbon::create($date)->format('d M Y');
                        $html = $this->html($view, $title, $motor_records, $this->motor_selected_columns);

                        return $this->renderPdf($html, $title);
                        break;

                    case 'trafos':

                        $view = 'maintenance.report.trafo';
                        $trafo_records = $this->query(TrafoRecord::class, $date, $date_after, $this->trafo_selected_columns);
                        $title = 'Fajar E-Maintenance' . ' - ' . 'Trafo daily report' . ' - ' . Carbon::create($date)->format('d M Y');
                        $html = $this->html($view, $title, $trafo_records, $this->trafo_selected_columns);

                        return $this->renderPdf($html, $title);
                        break;

                    default:
                        return redirect()->back()->withErrors($validator)->withInput();
                }
            } catch (Exception $error) {
                return redirect()->back()->withErrors($error->getMessage())->withInput();
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function reportEquipmentPdf(string $type, string $equipment, string $start_date, string $end_date)
    {
        $title = 'Fajar E-Maintenance' . ' - ' . 'Record of ' . $equipment . ' - [' . Carbon::create($start_date)->format('d M Y') . ' - ' . Carbon::create($end_date)->format('d M Y') . ']';

        if ($type == 'motors') {
            // MOTORS
            $view = 'maintenance.report.motor';
            $motor_records = MotorRecord::query()
                ->where('motor', $equipment)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->get();
            $html = $this->html($view, $title, $motor_records, $this->motor_selected_columns);
            return $this->renderPdf($html, $title);
        } else {
            // TRAFOS
            $view = 'maintenance.report.trafo';
            $trafo_records = TrafoRecord::query()
                ->where('trafo', $equipment)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->get();
            $html = $this->html($view, $title, $trafo_records, $this->trafo_selected_columns);
            return $this->renderPdf($html, $title);
        }
    }
}
