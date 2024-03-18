<?php

namespace App\Http\Controllers;

use App\Data\Alert;
use App\Data\Modal;
use App\Models\Trafo;
use App\Services\FunclocService;
use App\Services\TrafoDetailService;
use App\Services\TrafoService;
use App\Traits\Utility;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TrafoController extends Controller
{
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

    public function trafos(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $paginator = Trafo::query()
            ->when($search, function ($query, $search) {
                $query
                    ->where('id', 'LIKE', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                $query
                    ->where('status', '=', $status);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(1000)
            ->withQueryString();

        return view('maintenance.trafo.trafo', [
            'title' => 'Trafos',
            'paginator' => $paginator,
        ]);
    }

    public function trafoEdit(string $id)
    {
        $trafo = Trafo::query()->with(['TrafoDetail'])->find($id);

        if (is_null($trafo)) {
            return back()->with('modal', new Modal('[404] Not found', "The trafo $id is unregistered."));
        }

        return response()->view('maintenance.trafo.form', [
            'title' => 'Edit trafo',
            'trafoService' => $this->trafoService,
            'action' => 'trafo-update',
            'trafo' => $trafo,
            'trafoDetail' => $trafo->TrafoDetail,
        ]);
    }

    public function trafoDetails(string $id)
    {
        $trafo = Trafo::query()->with(['TrafoDetail'])->find($id);

        if (is_null($trafo)) {
            return back()->with('modal', new Modal('[404] Not found', "The trafo $id is unregistered."));
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
            'status' => ['required', Rule::in($this->getEnumValue('equipment', 'status'))],
            'funcloc' => ['nullable', 'prohibited_if:status,Available', 'prohibited_if:status,Repaired', 'required_if:status,Installed', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', 'exists:App\Models\Funcloc,id'],
            'sort_field' => ['nullable', 'prohibited_if:status,Available', 'prohibited_if:status,Repaired', 'required_if:status,Installed', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\#]+$/u'],
            'description' => ['nullable', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\;\,\#\=]+$/u'],
            'material_number' => ['nullable', 'digits:8', 'numeric'],
            'unique_id' => ['required', 'numeric', 'exists:App\Models\Trafo,unique_id'],
            'qr_code_link' => ['required', 'exists:App\Models\Trafo,qr_code_link'],
            'trafo_detail' => ['required', 'same:id'],
            'power_rate' => ['nullable', 'max:10'],
            'power_unit' => ['nullable', Rule::in($this->getEnumValue('trafo', 'power_unit'))],
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
                Log::error('trafo tries to updated', ['trafo' => $validated_trafo['id'], 'admin' => Auth::user()->fullname, 'message' => $error->getMessage()]);
                return back()->with('alert', new Alert($error->getMessage(), 'alert-danger'));
            }

            Log::info('trafo updated success', ['trafo' => $validated_trafo['id'], 'admin' => Auth::user()->fullname]);
            return back()->with('alert', new Alert('The trafo successfully updated.', 'alert-success'));
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
            'status' => ['required', Rule::in($this->getEnumValue('equipment', 'status'))],
            'funcloc' => ['nullable', 'prohibited_if:status,Available', 'prohibited_if:status,Repaired', 'required_if:status,Installed', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', Rule::in($this->funclocService->registeredFunclocs())],
            'sort_field' => ['nullable', 'prohibited_if:status,Available', 'prohibited_if:status,Repaired', 'required_if:status,Installed', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\#]+$/u'],
            'description' => ['nullable', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\;\,\#\=]+$/u'],
            'material_number' => ['nullable', 'numeric', 'digits:8'],
            'unique_id' => ['required', 'numeric', Rule::notIn($this->trafoService->registeredUniqueIds())],
            'qr_code_link' => ['required', 'starts_with:id=Fajar-TrafoList', Rule::notIn($this->trafoService->registeredQrCodeLinks())],

            'power_rate' => ['nullable', 'max:10'],
            'power_unit' => ['nullable', Rule::in($this->getEnumValue('trafo', 'power_unit'))],
            'primary_voltage' => ['nullable', 'max:10'],
            'secondary_voltage' => ['nullable', 'max:10'],
            'primary_current' => ['nullable', 'max:10'],
            'secondary_current' => ['nullable', 'max:10'],
            'primary_connection_type' => ['nullable', 'max:10'],
            'secondary_connection_type' => ['nullable', 'max:10'],
            'frequency' => ['nullable', 'max:10'],
            'type' => ['nullable', Rule::in($this->getEnumValue('trafo', 'type'))],
            'manufacturer' => ['nullable', 'max:50'],
            'year_of_manufacture' => ['nullable', 'size:4'],
            'serial_number' => ['nullable', 'max:25'],
            'vector_group' => ['nullable', 'max:25'],
            'insulation_class' => ['nullable', 'max:10'],
            'type_of_cooling' => ['nullable', 'max:10'],
            'temp_rise_oil_winding' => ['nullable', 'max:25'],
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

                $this->trafoService->register($validated_trafo);
                $this->trafoDetailService->register($validated_trafo_details);
            } catch (Exception $error) {
                Log::error('trafo registration error', ['trafo' => $validated_trafo['id'], 'admin' => Auth::user()->fullname, 'message' => $error->getMessage()]);
                return back()->with('alert', new Alert($error->getMessage(), 'alert-danger'));
            }

            Log::info('trafo register success', ['trafo' => $validated_trafo['id'], 'admin' => Auth::user()->fullname]);
            return back()->with('alert', new Alert('The trafo successfully registered.', 'alert-success', 'trafo-edit/' .  $validated_trafo['id']));
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function trafoInstallDismantle()
    {
        return response()->view('maintenance.install-dismantle', [
            'title' => 'Install dismantle',
            'table' => 'Trafos',
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
                Log::error('trafo install dismantle error', ['trafo_dismantle' => $dismantle, 'trafo_install' => $install, 'admin' => Auth::user()->fullname, 'message' => $error->getMessage()]);
                return back()->with('modal', new Modal('[500] Internal Server Error', $error->getMessage()));
            }

            Log::info('trafo install dismantle success', ['trafo_dismantle' => $dismantle, 'trafo_install' => $install, 'admin' => Auth::user()->fullname]);
            return back()->with('modal', new Modal('[200] Success', 'The trafo was successfully swapped.'));
        } else {
            return back()->with('modal', new Modal('[403] Forbidden', $validator->errors()->first()));
        }
    }
}
