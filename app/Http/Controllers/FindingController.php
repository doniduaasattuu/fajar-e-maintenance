<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Finding;
use App\Services\FindingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FindingController extends Controller
{

    private FindingService $findingService;

    public function __construct(FindingService $findingService)
    {
        $this->findingService = $findingService;
    }

    public function findings()
    {
        $findings = DB::table('findings')
            ->orderBy('created_at', 'desc')
            ->get();

        $equipments = DB::table('findings')->distinct()->get(['equipment']);
        $equipments = $equipments->map(function ($value, $key) {
            return $value->equipment;
        });

        return response()->view('maintenance.finding.finding', [
            'title' => 'Findings',
            'findings' => $findings,
            'equipments' => $equipments->whereNotNull()->all(),
            'findingService' => $this->findingService,
        ]);
    }

    public function findingRegistration()
    {
        return response()->view('maintenance.finding.form', [
            'title' => 'Finding registration',
            'findingService' => $this->findingService,
            'action' => 'finding-register'
        ]);
    }

    public function findingRegister(Request $request)
    {
        $rules = [
            'id' => ['nullable'],
            'area' => ['nullable'],
            'description' => ['nullable'],
            'image' => ['nullable'],
            'status' => ['nullable'],
            'equipment' => ['nullable'],
            'funcloc' => ['nullable'],
            'notification' => ['nullable'],
            'reporter' => ['nullable'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            return redirect()->back()->with('alert', ['message' => 'The finding successfully saved.', 'variant' => 'alert-success']);
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function findingEdit(string $id)
    {
        return "Finding edit $id";
    }

    public function findingDelete(string $id)
    {
        return "Finding delete $id";
    }
}
