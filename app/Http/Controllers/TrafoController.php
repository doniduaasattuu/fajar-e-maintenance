<?php

namespace App\Http\Controllers;

use App\Models\Trafo;
use App\Services\TrafoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TrafoController extends Controller
{

    private TrafoService $trafoService;

    public function __construct(TrafoService $trafoService)
    {
        $this->trafoService = $trafoService;
    }

    public function trafos()
    {
        return response()->view('maintenance.trafo.trafo', [
            'title' => 'Table trafo',
            'trafoService' => $this->trafoService,
        ]);
    }

    public function trafoEdit(string $id)
    {
        $trafo = Trafo::query()->with(['trafoDetail'])->find($id);

        if (is_null($trafo)) {
            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The trafo $id is unregistered."]);
        }

        return response()->view('maintenance.trafo.form', [
            'title' => 'Edit trafo',
            'trafoService' => $this->trafoService,
            'action' => 'trafo-update',
            'trafo' => $trafo,
        ]);
    }

    public function trafoUpdate(Request $request)
    {
        $rules = [
            'id' => ['required', 'size:9', 'exists:App\Models\Trafo,id'],
            'status' => ['required', Rule::in($this->trafoService->equipmentStatus)],
            'funcloc' => ['nullable', 'prohibited_if:status,Available', 'prohibited_if:status,Repaired', 'required_if:status,Installed', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', 'exists:App\Models\Funcloc,id'],
            'sort_field' => ['nullable', 'prohibited_if:status,Available', 'prohibited_if:status,Repaired', 'required_if:status,Installed', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\#]+$/u'],
            'description' => ['nullable', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\;\,\#\=]+$/u'],
            'material_number' => ['nullable', 'digits:8', 'numeric'],
            'unique_id' => ['required', 'numeric', 'exists:App\Models\Trafo,unique_id'],
            'qr_code_link' => ['required', 'exists:App\Models\Trafo,qr_code_link'],
            'trafo_detail' => ['required', 'same:id'],
            'power_rate' => ['nullable', 'max:10'],
            'power_unit' => ['nullable', Rule::in($this->trafoService->powerUnitEnum)],
            'primary_voltage' => ['nullable', 'max:10'],
            'secondary_voltage' => ['nullable', 'max:10'],
            'primary_current' => ['nullable', 'max:10'],
            'secondary_current' => ['nullable', 'max:10'],
            'primary_connection_type' => ['nullable', 'max:10'],
            'secondary_connection_type' => ['nullable', 'max:10'],
            'frequency' => ['nullable', 'max:10'],
            'type' => ['nullable', 'max:25'],
            'manufacturer' => ['nullable', 'max:50'],
            'year_of_manufacture' => ['nullable', 'size:4'],
            'serial_number' => ['nullable', 'max:25'],
            'vector_group' => ['nullable', 'max:25'],
            'insulation_class' => ['nullable', 'max:10'],
            'type_of_cooling' => ['nullable', 'max:50'],
            'temp_rise_oil_winding' => ['nullable', 'max:50'],
            'weight' => ['nullable', 'max:25'],
            'weight_of_oil' => ['nullable', 'max:25'],
            'oil_type' => ['nullable', 'max:25'],
            'ip_rating' => ['nullable', 'max:25'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated = $validator->validated();
            return response()->json($validated);
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}
