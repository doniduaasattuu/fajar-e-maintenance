<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueController extends Controller
{
    public function issues()
    {
        $issues = Issue::query()->where('department', '=', Auth::user()->department)->get();
        return view('maintenance.issue.issue', [
            'issues' => $issues,
        ]);
    }

    public function issueRegistration()
    {
        return response()->view('maintenance.issue.form', [
            'title' => 'New issue',
            'action' => 'issue-register'
        ]);
    }
}
