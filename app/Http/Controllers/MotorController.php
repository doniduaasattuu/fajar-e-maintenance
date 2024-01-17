<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Services\FunclocService;
use App\Services\MotorService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MotorController extends Controller
{
    private MotorService $motorService;
    private FunclocService $funclocService;

    public function __construct(MotorService $motorService, FunclocService $funclocService)
    {
        $this->motorService = $motorService;
        $this->funclocService = $funclocService;
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
        $motor = Motor::query()->find($id);

        if (is_null($motor)) {
            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The motor $id is unregistered."]);
        }

        return response()->view('maintenance.motor.form', [
            'title' => 'Edit motor',
            'motorService' => $this->motorService,
            'motor' => $motor,
            'action' => 'motor-update'
        ]);
    }

    public function motorDetails(string $id)
    {
        $motor = Motor::query()->find($id);

        if (is_null($motor)) {
            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The motor $id is unregistered."]);
        }

        return response()->view('maintenance.motor.form', [
            'title' => 'Motor details',
            'motor' => $motor,
            'readonly' => true,
            'motorService' => $this->motorService,
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
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated = $validator->validated();

            try {
                $this->motorService->updateMotor($validated);
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
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated = $validator->validated();

            try {
                $this->motorService->register($validated);
            } catch (Exception $error) {
                return redirect()->back()->with('alert', ['message' => $error->getMessage(), 'variant' => 'alert-danger']);
            }

            return redirect()->back()->with('alert', ['message' => 'The motor successfully registered.', 'variant' => 'alert-success']);
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}
