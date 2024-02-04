<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Finding;
use App\Services\FindingService;
use Illuminate\Http\Request;

class FindingController extends Controller
{

    private FindingService $findingService;

    public function __construct(FindingService $findingService)
    {
        $this->findingService = $findingService;
    }

    public function findings()
    {
        $findings = Finding::query()->get();
        // return response()->json($findings);
        return response()->view('maintenance.finding.finding', [
            'title' => 'Findings',
            'findings' => $findings,
            'findingService' => $this->findingService,
        ]);
    }
}
