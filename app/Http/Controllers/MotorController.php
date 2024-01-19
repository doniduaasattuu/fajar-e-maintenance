<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Services\FunclocService;
use App\Services\MotorDetailService;
use App\Services\MotorService;
use App\Traits\Utility;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MotorController extends Controller
{
    use Utility;

    private MotorService $motorService;
    private FunclocService $funclocService;
    private MotorDetailService $motorDetailService;

    public function __construct(
        MotorService $motorService,
        FunclocService $funclocService,
        MotorDetailService $motorDetailService,
    ) {
        $this->motorService = $motorService;
        $this->funclocService = $funclocService;
        $this->motorDetailService = $motorDetailService;
    }

    public function motors()
    {
        return response()->view('maintenance.motor.motor', [
            'title' => 'Table motor',
            'motorService' => $this->motorService,
        ]);
    }

    public function motorEdit(string $id)
    {
        $motor = Motor::query()->with(['MotorDetail'])->find($id);

        if (is_null($motor)) {
            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The motor $id is unregistered."]);
        }

        return response()->view('maintenance.motor.form', [
            'title' => 'Edit motor',
            'motorService' => $this->motorService,
            'action' => 'motor-update',
            'motor' => $motor,
        ]);
    }

    public function motorDetails(string $id)
    {
        $motor = Motor::query()->with(['MotorDetail'])->find($id);

        if (is_null($motor)) {
            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The motor $id is unregistered."]);
        }

        return response()->view('maintenance.motor.form', [
            'title' => 'Motor details',
            'motorService' => $this->motorService,
            'motor' => $motor,
        ]);
    }

    public function motorUpdate(Request $request)
    {
        $rules = [
            'id' => ['required', 'size:9', 'exists:App\Models\Motor,id'],
            'status' => ['required', Rule::in($this->motorService->statusEnum())],
            'funcloc' => ['nullable', 'required_if:status,Installed', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', 'exists:App\Models\Funcloc,id'],
            'sort_field' => ['nullable', 'required_if:status,Installed', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\#]+$/u'],
            'description' => ['nullable', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\;\,\#]+$/u'],
            'material_number' => ['nullable', 'digits:8', 'numeric'],
            'unique_id' => ['required', 'numeric', 'exists:App\Models\Motor,unique_id'],
            'qr_code_link' => ['required', 'exists:App\Models\Motor,qr_code_link'],
            'motor_detail' => ['required', 'same:id'],
            'manufacturer' => ['nullable', 'max:50'],
            'serial_number' => ['nullable', 'max:50'],
            'type' => ['nullable', 'max:50'],
            'power_rate' => ['nullable', 'max:10'],
            'power_unit' => ['nullable', Rule::in($this->motorService->powerUnitEnum())],
            'voltage' => ['nullable', 'max:10'],
            'electrical_current' => ['nullable', Rule::in($this->motorService->electricalCurrentEnum())],
            'current_nominal' => ['nullable', 'max:10'],
            'frequency' => ['nullable', 'max:10'],
            'pole' => ['nullable', 'max:5'],
            'rpm' => ['nullable', 'max:10'],
            'bearing_de' => ['nullable', 'max:25'],
            'bearing_nde' => ['nullable', 'max:25'],
            'frame_type' => ['nullable', 'max:25'],
            'shaft_diameter' => ['nullable', 'max:6'],
            'phase_supply' => ['nullable', 'max:3', 'numeric', 'digits_between:1,3'],
            'cos_phi' => ['nullable', 'decimal:2', 'max:1'],
            'efficiency' => ['nullable', 'decimal:2', 'max:1'],
            'ip_rating' => ['nullable', 'max:10'],
            'insulation_class' => ['nullable', 'max:5'],
            'duty' => ['nullable', 'max:5'],
            'connection_type' => ['nullable', 'max:25'],
            'nipple_grease' => ['nullable', Rule::in($this->motorService->nippleGreaseEnum())],
            'greasing_type' => ['nullable', 'max:25'],
            'greasing_qty_de' => ['nullable', 'max:10'],
            'greasing_qty_nde' => ['nullable', 'max:10'],
            'length' => ['nullable', 'max:10'],
            'width' => ['nullable', 'max:10'],
            'height' => ['nullable', 'max:10'],
            'weight' => ['nullable', 'max:10'],
            'cooling_fan' => ['nullable', Rule::in($this->motorService->coolingFanEnum())],
            'mounting' => ['nullable', Rule::in($this->motorService->mountingEnum())],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated_motor = $validator->safe()->except($this->getColumns('motor_details', ['id']));
            $validated_motor_details = $validator->safe()->merge(['motor_detail' => $validated_motor['id']])->except($this->getColumns('motors'));

            try {
                $this->motorService->updateMotor($validated_motor);
                $this->motorDetailService->updateMotorDetail($validated_motor_details);
            } catch (Exception $error) {
                return redirect()->back()->with('alert', ['message' => $error->getMessage(), 'variant' => 'alert-danger']);
            }

            return redirect()->back()->with('alert', ['message' => 'The motor successfully updated.', 'variant' => 'alert-success']);
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function motorRegistration()
    {
        return response()->view('maintenance.motor.form', [
            'title' => 'Motor registration',
            'motorService' => $this->motorService,
            'action' => 'motor-register'
        ]);
    }

    public function motorRegister(Request $request)
    {
        $rules = [
            'id' => ['required', 'size:9', 'starts_with:EMO,MGM,MGB,MDO,MFB', Rule::notIn($this->motorService->registeredMotors())],
            'status' => ['required', Rule::in($this->motorService->statusEnum())],
            'funcloc' => ['nullable', 'required_if:status,Installed', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', Rule::in($this->funclocService->registeredFunclocs())],
            'sort_field' => ['nullable', 'required_if:status,Installed', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\#]+$/u'],
            'description' => ['nullable', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\;\,\#]+$/u'],
            'material_number' => ['nullable', 'numeric', 'digits:8'],
            'unique_id' => ['required', 'numeric', Rule::notIn($this->motorService->registeredUniqueIds())],
            'qr_code_link' => ['required', 'starts_with:https://www.safesave.info/MIC.php?id=Fajar-MotorList', Rule::notIn($this->motorService->registeredQrCodeLinks())],

            'manufacturer' => ['nullable', 'max:50'],
            'serial_number' => ['nullable', 'max:50'],
            'type' => ['nullable', 'max:50'],
            'power_rate' => ['nullable', 'max:10'],
            'power_unit' => ['nullable', Rule::in($this->motorService->powerUnitEnum())],
            'voltage' => ['nullable', 'max:10'],
            'electrical_current' => ['nullable', Rule::in($this->motorService->electricalCurrentEnum())],
            'current_nominal' => ['nullable', 'max:10'],
            'frequency' => ['nullable', 'max:10'],
            'pole' => ['nullable', 'max:5'],
            'rpm' => ['nullable', 'max:10'],
            'bearing_de' => ['nullable', 'max:25'],
            'bearing_nde' => ['nullable', 'max:25'],
            'frame_type' => ['nullable', 'max:25'],
            'shaft_diameter' => ['nullable', 'max:6'],
            'phase_supply' => ['nullable', 'max:3', 'numeric', 'digits_between:1,3'],
            'cos_phi' => ['nullable', 'decimal:2', 'max:1'],
            'efficiency' => ['nullable', 'decimal:2', 'max:1'],
            'ip_rating' => ['nullable', 'max:10'],
            'insulation_class' => ['nullable', 'max:5'],
            'duty' => ['nullable', 'max:5'],
            'connection_type' => ['nullable', 'max:25'],
            'nipple_grease' => ['nullable', Rule::in($this->motorService->nippleGreaseEnum())],
            'greasing_type' => ['nullable', 'max:25'],
            'greasing_qty_de' => ['nullable', 'max:10'],
            'greasing_qty_nde' => ['nullable', 'max:10'],
            'length' => ['nullable', 'max:10'],
            'width' => ['nullable', 'max:10'],
            'height' => ['nullable', 'max:10'],
            'weight' => ['nullable', 'max:10'],
            'cooling_fan' => ['nullable', Rule::in($this->motorService->coolingFanEnum())],
            'mounting' => ['nullable', Rule::in($this->motorService->mountingEnum())],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated_motor = $validator->safe()->except($this->getColumns('motor_details', ['id']));
            $validated_motor_details = $validator->safe()->merge(['motor_detail' => $validated_motor['id']])->except($this->getColumns('motors'));

            try {

                $this->motorService->register($validated_motor);
                $this->motorDetailService->register($validated_motor_details);
            } catch (Exception $error) {
                return redirect()->back()->with('alert', ['message' => $error->getMessage(), 'variant' => 'alert-danger']);
            }

            return redirect()->back()->with('alert', ['message' => 'The motor successfully registered.', 'variant' => 'alert-success']);
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}
