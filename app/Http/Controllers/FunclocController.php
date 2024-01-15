<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Funcloc;
use App\Services\FunclocService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FunclocController extends Controller
{
    private FunclocService $funclocService;

    public function __construct(FunclocService $funclocService)
    {
        $this->funclocService = $funclocService;
    }

    public function funclocs()
    {
        return response()->view('maintenance.funcloc.funcloc', [
            'title' => 'Table funcloc',
            'funclocService' => $this->funclocService,
        ]);
    }

    public function funclocEdit(string $id)
    {
        $funcloc = Funcloc::query()->find($id);

        return response()->view('maintenance.funcloc.form', [
            'title' => 'Edit funcloc',
            'funclocService' => $this->funclocService,
            'funcloc' => $funcloc,
            'action' => 'funcloc-update'
        ]);
    }

    public function funclocUpdate(Request $request)
    {
        $rules = [
            'id' => ['required', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', 'exists:App\Models\Funcloc,id'],
            'description' => ['nullable', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\#]+$/u'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated = $validator->validated();
            $this->funclocService->updateFuncloc($validated);

            return redirect()->back()->with('alert', ['message' => 'The funcloc successfully updated.', 'variant' => 'alert-success']);
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function funclocRegistration()
    {
        return response()->view('maintenance.funcloc.form', [
            'title' => 'Funcloc registration',
            'funclocService' => $this->funclocService,
            'action' => 'funcloc-register'
        ]);
    }

    public function funclocRegister(Request $request)
    {
        $rules = [
            'id' => ['required', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', Rule::notIn($this->funclocService->registeredFunclocs())],
            'description' => ['nullable', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\#]+$/u'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $validated = $validator->validated();

            $this->funclocService->register($validated);
            return redirect()->back()->with('alert', ['message' => 'The funcloc successfully registered.', 'variant' => 'alert-success']);
            // return response()->json($validated);
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}
