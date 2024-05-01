<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueController extends Controller
{
    public function issues(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');


        $issues = Issue::query()
            ->when($search, function ($query, $search) {
                $query
                    ->where(function ($builder) use ($search) {
                        $builder
                            ->orWhere('description', 'LIKE', "%{$search}%")
                            ->orWhere('corrective_action', 'LIKE', "%{$search}%")
                            ->orWhere('root_cause', 'LIKE', "%{$search}%")
                            ->orWhere('preventive_action', 'LIKE', "%{$search}%")
                            ->orWhere('remark', 'LIKE', "%{$search}%");
                    });
            })
            ->when($status, function ($query, $status) {
                $query
                    ->where('status', $status);
            })
            ->where('department', Auth::user()->department)
            ->get();

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
