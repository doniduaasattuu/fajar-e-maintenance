<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Services\MotorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MotorController extends Controller
{
    private MotorService $motorService;

    public function __construct(MotorService $motorService)
    {
        $this->motorService = $motorService;
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
            'description' => ['required', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\;\,\#]+$/u'],
            'material_number' => ['required', 'digits:8', 'numeric'],
            'unique_id' => ['required', 'exists:App\Models\Motor,unique_id'],
            'qr_code_link' => ['required', 'exists:App\Models\Motor,qr_code_link'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated = $validator->validated();
            // return response()->json($validated);
            $this->motorService->updateMotor($validated);

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
}
