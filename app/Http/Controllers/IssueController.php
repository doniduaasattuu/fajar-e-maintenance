<?php

namespace App\Http\Controllers;

use App\Data\Alert;
use App\Data\Modal;
use App\Models\Issue;
use Carbon\Carbon;
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
                            ->orWhere('section', 'LIKE', "%{$search}%")
                            ->orWhere('area', 'LIKE', "%{$search}%")
                            ->orWhere('description', 'LIKE', "%{$search}%")
                            ->orWhere('corrective_action', 'LIKE', "%{$search}%")
                            ->orWhere('root_cause', 'LIKE', "%{$search}%")
                            ->orWhere('preventive_action', 'LIKE', "%{$search}%")
                            ->orWhere('remark', 'LIKE', "%{$search}%")
                            ->orWhere('created_at', 'LIKE', "%{$search}%")
                            ->orWhere('created_by', 'LIKE', "%{$search}%");
                    });
            })
            ->when($status, function ($query, $status) {
                $query
                    ->where('status', $status);
            })
            ->where('department', Auth::user()->department)
            ->orderBy('target_date', 'DESC')
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

    public function issueRegister(Request $request)
    {
        $user = Auth::user();

        $request->merge([
            'id' => uniqid(),
            'issued_date' => Carbon::now()->toDateTimeString(),
            'remaining_days' => $request->input('target_date'),
            'department' => $user->department,
            'created_by' => $user->fullname,
        ]);

        $validated = $request->validate([
            'id' => ['required'],
            'issued_date' => ['required'],
            'target_date' => ['required'],
            'remaining_days' => ['required'],
            'section' => ['required'],
            'area' => ['required'],
            'description' => ['required'],
            'corrective_action' => ['nullable'],
            'root_cause' => ['nullable'],
            'preventive_action' => ['nullable'],
            'status' => ['required'],
            'remark' => ['nullable'],
            'department' => ['required'],
            'created_by' => ['required'],
            'updated_by' => ['nullable'],
        ]);

        // return response()->json($validated);
        $issue = new Issue($validated);
        $issue->save();

        return back()->with('alert', new Alert('Issue successfully saved.', 'alert-success'));
    }

    public function issueEdit(string $id)
    {
        $issue = Issue::query()->find($id);

        if (!is_null($issue)) {

            return response()->view('maintenance.issue.form', [
                'title' => 'Edit issue',
                'action' => 'issue-update',
                'issue' => $issue,
            ]);
        } else {
            return back()->with('modal', new Modal('[404] Not found', 'Issue not found.'));
        }
    }

    public function issueUpdate(Request $request)
    {
        return response()->json($request->input());
    }

    public function issueDelete(string $id)
    {
        $issue = Issue::query()->find($id);

        if (!is_null($issue)) {

            $issue->delete();
            return back()->with('modal', new Modal('[204] Success', 'Issue successfully deleted.'));
        } else {
            return back()->with('modal', new Modal('[404] Not found', 'Issue not found.'));
        }
    }
}
