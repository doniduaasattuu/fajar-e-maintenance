<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Finding;
use App\Services\FindingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
