<?php

namespace App\Http\Controllers;

use App\Models\Trafo;
use App\Services\FunclocService;
use App\Services\TrafoDetailService;
use App\Services\TrafoService;
use App\Traits\Utility;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TrafoController extends Controller
{
    use Utility;
    private TrafoService $trafoService;
    private FunclocService $funclocService;
    private TrafoDetailService $trafoDetailService;

    public function __construct(
        TrafoService $trafoService,
        FunclocService $funclocService,
        TrafoDetailService $trafoDetailService,
    ) {
        $this->trafoService = $trafoService;
        $this->funclocService = $funclocService;
        $this->trafoDetailService = $trafoDetailService;
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

    public function trafoDetails(string $id)
    {
        $trafo = Trafo::query()->with(['TrafoDetail'])->find($id);

        if (is_null($trafo)) {
            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The trafo $id is unregistered."]);
        }

        return response()->view('maintenance.trafo.form', [
            'title' => 'Trafo details',
            'trafoService' => $this->trafoService,
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

            $validated_trafo = $validator->safe()->except($this->getColumns('trafo_details', ['id']));
            $validated_trafo_details = $validator->safe()->merge(['trafo_detail' => $validated_trafo['id']])->except($this->getColumns('trafos'));

            try {

                $this->trafoService->updateTrafo($validated_trafo);
                $this->trafoDetailService->updateTrafoDetail($validated_trafo_details);
            } catch (Exception $error) {
                return redirect()->back()->with('alert', ['message' => $error->getMessage(), 'variant' => 'alert-danger']);
            }

            return redirect()->back()->with('alert', ['message' => 'The trafo successfully updated.', 'variant' => 'alert-success']);
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function trafoRegistration()
    {
        return response()->view('maintenance.trafo.form', [
            'title' => 'Trafo registration',
            'trafoService' => $this->trafoService,
            'action' => 'trafo-register'
        ]);
    }

    public function trafoRegister(Request $request)
    {
        $rules = [
            'id' => ['required', 'regex:/^[a-zA-Z\d]+$/u', 'size:9', 'starts_with:ETF', Rule::notIn($this->trafoService->registeredTrafos())],
            'status' => ['required', Rule::in($this->trafoService->equipmentStatus)],
            'funcloc' => ['nullable', 'prohibited_if:status,Available', 'prohibited_if:status,Repaired', 'required_if:status,Installed', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', Rule::in($this->funclocService->registeredFunclocs())],
            'sort_field' => ['nullable', 'prohibited_if:status,Available', 'prohibited_if:status,Repaired', 'required_if:status,Installed', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\#]+$/u'],
            'description' => ['nullable', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\;\,\#\=]+$/u'],
            'material_number' => ['nullable', 'numeric', 'digits:8'],
            'unique_id' => ['required', 'numeric', Rule::notIn($this->trafoService->registeredUniqueIds())],
            'qr_code_link' => ['required', 'starts_with:id=Fajar-TrafoList', Rule::notIn($this->trafoService->registeredQrCodeLinks())],

            'power_rate' => ['nullable'],
            'power_unit' => ['nullable'],
            'primary_voltage' => ['nullable'],
            'secondary_voltage' => ['nullable'],
            'primary_current' => ['nullable'],
            'secondary_current' => ['nullable'],
            'primary_connection_type' => ['nullable'],
            'secondary_connection_type' => ['nullable'],
            'frequency' => ['nullable'],
            'type' => ['nullable'],
            'manufacturer' => ['nullable'],
            'year_of_manufacture' => ['nullable'],
            'serial_number' => ['nullable'],
            'vector_group' => ['nullable'],
            'insulation_class' => ['nullable'],
            'type_of_cooling' => ['nullable'],
            'temp_rise_oil_winding' => ['nullable'],
            'weight' => ['nullable'],
            'weight_of_oil' => ['nullable'],
            'oil_type' => ['nullable'],
            'ip_rating' => ['nullable'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated_trafo = $validator->safe()->except($this->getColumns('trafo_details', ['id']));
            $validated_trafo_details = $validator->safe()->merge(['trafo_detail' => $validated_trafo['id']])->except($this->getColumns('trafos'));

            try {

                $this->trafoService->register($validated_trafo);
                $this->trafoDetailService->register($validated_trafo_details);
            } catch (Exception $error) {
                return redirect()->back()->with('alert', ['message' => $error->getMessage(), 'variant' => 'alert-danger']);
            }
            return redirect()->back()->with('alert', ['message' => 'The trafo successfully registered.', 'variant' => 'alert-success']);
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function trafoInstallDismantle()
    {
        return response()->view('maintenance.trafo.install-dismantle', [
            'title' => 'Install dismantle'
        ]);
    }

    public function equipmentTrafo(Request $request)
    {
        $equipment = $request->input('equipment');
        $status = $request->input('status');

        $trafo = Trafo::query()->with(['TrafoDetail'])->find($equipment);

        if (!is_null($trafo)) {
            if ($trafo->status == $status) {
                return response()->json($trafo);
            } else {
                return response()->json(null);
            }
        } else {
            return response()->json($trafo);
        }
    }

    public function doTrafoInstallDismantle(Request $request)
    {
        $rules = [
            'id_dismantle' => ['required', 'size:9', 'different:id_install', Rule::in($this->trafoService->registeredTrafos())],
            'id_install' => ['required', 'size:9', 'different:id_dismantle', Rule::in($this->trafoService->registeredTrafos())],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated = $validator->validated();
            $dismantle = $validated['id_dismantle'];
            $install = $validated['id_install'];

            try {
                $this->trafoService->installDismantle($dismantle, $install);
            } catch (Exception $error) {

                return redirect()->back()->with('message', ['header' => '[500] Internal Server Error', 'message' => $error->getMessage()]);
            }

            return redirect()->back()->with('message', ['header' => '[200] Success!', 'message' => "The trafo was successfully swapped."]);
        } else {
            return redirect()->back()->with('message', ['header' => '[403] Forbidden', 'message' => $validator->errors()->first()]);
        }
    }
}
