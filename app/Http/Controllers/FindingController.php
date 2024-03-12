<?php

namespace App\Http\Controllers;

use App\Data\Alert;
use App\Data\Modal;
use App\Http\Controllers\Controller;
use App\Models\Finding;
use App\Services\FindingService;
use App\Services\FunclocService;
use App\Services\MotorService;
use App\Services\TrafoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class FindingController extends Controller
{

    private FindingService $findingService;
    private FunclocService $funclocService;
    private MotorService $motorService;
    private TrafoService $trafoService;

    public function __construct(
        FindingService $findingService,
        FunclocService $funclocService,
        MotorService $motorService,
        TrafoService $trafoService,
    ) {
        $this->findingService = $findingService;
        $this->funclocService = $funclocService;
        $this->motorService = $motorService;
        $this->trafoService = $trafoService;
    }

    public function findings(Request $request)
    {
        $dept = $request->query('dept');
        $status = $request->query('status');
        $search = $request->query('search');

        $paginator = Finding::query()
            ->when($dept, function ($query, $dept) {
                $query
                    ->where('department', '=', $dept);
            })
            ->when($status, function ($query, $status) {
                $query
                    ->where('status', '=', $status);
            })
            ->when($search, function ($query, $search) {
                $query
                    ->where('description', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(50)
            ->withQueryString();

        return view('maintenance.finding.finding', [
            'title' => 'Findings',
            'paginator' => $paginator,
        ]);
    }

    public function findingRegistration()
    {
        return response()->view('maintenance.finding.form', [
            'title' => 'New finding',
            'action' => 'finding-register'
        ]);
    }

    public function findingRegister(Request $request)
    {
        $request->mergeIfMissing(['id' => uniqid(), 'reporter' => Auth::user()->fullname]);

        $validated = $request->validate([
            'id' => ['required', 'size:13'],
            'area' => ['required', Rule::in($this->areas())],
            'department' => ['required', Rule::in($this->getEnumValue('user', 'department'))],
            'status' => ['required', Rule::in($this->findingService->findingStatusEnum)],
            'equipment' => ['nullable', Rule::in(array_merge($this->motorService->registeredMotors(), $this->trafoService->registeredTrafos()))],
            'funcloc' => ['nullable', Rule::in($this->funclocService->registeredFunclocs())],
            'notification' => ['nullable', 'numeric', 'digits:8'],
            'reporter' => ['required'],
            'description' => ['required', 'min:15'],
            'image' => ['nullable', 'prohibited_if:description,null', 'max:5000', File::types(['png', 'jpeg', 'jpg'])],
        ]);

        $image = $request->file('image');

        if (!is_null($image) && $image->isValid()) {
            $validated['image'] = $validated['id'] . '.' . strtolower($image->getClientOriginalExtension());
            $this->findingService->insertWithImage($image, $validated);
        } else {
            $this->findingService->insert($validated);
        }

        return redirect()->back()->with('alert', new Alert('The finding successfully saved.', 'alert-success', 'finding-edit/' . $validated['id']));
    }

    public function findingEdit(string $id)
    {
        $finding = Finding::query()->find($id);

        if (!is_null($finding)) {

            return response()->view('maintenance.finding.form', [
                'title' => 'Edit finding',
                'findingService' => $this->findingService,
                'action' => 'finding-update',
                'finding' => $finding,
            ]);
        } else {

            return back()->with('modal', new Modal('[404] Not found', 'Finding not found.'));
        }
    }

    public function findingUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'exists:App\Models\Finding,id'],
            'area' => ['required', Rule::in($this->areas())],
            'department' => ['required', Rule::in($this->getEnumValue('user', 'department'))],
            'status' => ['required', Rule::in($this->findingService->findingStatusEnum)],
            'equipment' => ['nullable', Rule::in(array_merge($this->motorService->registeredMotors(), $this->trafoService->registeredTrafos()))],
            'funcloc' => ['nullable', Rule::in($this->funclocService->registeredFunclocs())],
            'notification' => ['nullable', 'numeric', 'digits:8'],
            'reporter' => ['required'],
            'description' => ['required', 'min:15'],
            'image' => ['nullable', 'prohibited_if:description,null', 'max:5000', File::types(['png', 'jpeg', 'jpg'])],
        ]);

        $image = $request->file('image');

        if (!is_null($image) && $image->isValid()) {
            $validated['image'] = $validated['id'] . '.' . strtolower($image->getClientOriginalExtension());
            $this->findingService->updateWithImage($image, $validated);
        } else {
            $this->findingService->update($validated);
        }

        return redirect()->back()->with('alert', new Alert('The finding successfully updated.', 'alert-success'));
    }

    public function findingDelete(string $id)
    {
        $finding = Finding::query()->find($id);

        if (!is_null($finding)) {

            if (!is_null($finding->image)) {
                Storage::disk('public')->delete("findings/$finding->image");
            }
            $finding->delete();

            return back()->with('modal', new Modal('[204] Success', 'Finding successfully deleted.'));
        } else {
            return back()->with('modal', new Modal('[404] Not found', 'Finding not found.'));
        }
    }
}
