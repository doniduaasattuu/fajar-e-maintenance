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
use Illuminate\Support\Facades\DB;
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

    // public function findings()
    // {
    //     $findings = DB::table('findings')
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     $equipments = DB::table('findings')->distinct()->get(['equipment']);
    //     $equipments = $equipments->map(function ($value, $key) {
    //         return $value->equipment;
    //     });

    //     return response()->view('maintenance.finding.finding', [
    //         'title' => 'Findings',
    //         'findings' => $findings,
    //         'equipments' => $equipments->whereNotNull()->all(),
    //         'findingService' => $this->findingService,
    //     ]);
    // }

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
            ->paginate(4)
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

    // public function findingRegister(Request $request)
    // {
    //     $request->mergeIfMissing(['id' => uniqid(), 'reporter' => Auth::user()->fullname]);

    //     $rules = [
    //         'id' => ['required', 'size:13'],
    //         'area' => ['required', Rule::in($this->areas())],
    //         'status' => ['required', Rule::in($this->findingService->findingStatusEnum)],
    //         'equipment' => ['nullable', Rule::in(array_merge($this->motorService->registeredMotors(), $this->trafoService->registeredTrafos()))],
    //         'funcloc' => ['nullable', Rule::in($this->funclocService->registeredFunclocs())],
    //         'notification' => ['nullable', 'numeric', 'digits:8'],
    //         'reporter' => ['required'],
    //         'description' => ['required', 'min:15'],
    //         'image' => ['nullable', 'prohibited_if:description,null', 'max:5000', File::types(['png', 'jpeg', 'jpg'])],
    //     ];

    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->passes()) {

    //         try {

    //             $image = $request->file('image');
    //             $validated = $validator->safe()->except(['image']);

    //             if (!is_null($image) && $image->isValid()) {
    //                 $validated['image'] = $validated['id'] . '.' . strtolower($image->getClientOriginalExtension());
    //                 $this->findingService->insertWithImage($image, $validated);
    //                 Log::info('finding of ' . (!is_null($validated['equipment']) ? $validated['equipment'] : 'equipment not set') . ' ' . $validated['area'] . ' with image was inserted', ['user' => session('user')]);
    //             } else {
    //                 Log::info('finding of ' . (!is_null($validated['equipment']) ? $validated['equipment'] : 'equipment not set') . ' ' . $validated['area'] . ' without image was inserted', ['user' => session('user')]);
    //                 $this->findingService->insert($validated);
    //             }
    //         } catch (Exception $error) {
    //             Log::error('finding of ' . (!is_null($validated['equipment']) ? $validated['equipment'] : 'equipment not set') . ' ' . $validated['area'], ['user' => session('user'), 'message' => $error->getMessage()]);
    //             return redirect()->back()->withErrors($error->getMessage())->withInput();
    //         }

    //         return redirect()->back()->with('alert', ['message' => 'The finding successfully saved.', 'variant' => 'alert-success']);
    //     } else {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }
    // }

    public function findingRegister(Request $request)
    {
        $request->mergeIfMissing(['id' => uniqid(), 'reporter' => Auth::user()->fullname]);

        $validated = $request->validate([
            'id' => ['required', 'size:13'],
            'area' => ['required', Rule::in($this->areas())],
            'department' => ['required', Rule::in($this::$departments)],
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

    // public function findingUpdate(Request $request)
    // {
    //     $rules = [
    //         'id' => ['required', 'exists:App\Models\Finding,id'],
    //         'area' => ['required', Rule::in($this->areas())],
    //         'status' => ['required', Rule::in($this->findingService->findingStatusEnum)],
    //         'equipment' => ['nullable', Rule::in(array_merge($this->motorService->registeredMotors(), $this->trafoService->registeredTrafos()))],
    //         'funcloc' => ['nullable', Rule::in($this->funclocService->registeredFunclocs())],
    //         'notification' => ['nullable', 'numeric', 'digits:8'],
    //         'reporter' => ['required'],
    //         'description' => ['required', 'min:15'],
    //         'image' => ['nullable', 'prohibited_if:description,null', 'max:5000', File::types(['png', 'jpeg', 'jpg'])],
    //     ];

    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->passes()) {

    //         $validated = $validator->validated();
    //         $image = $request->file('image');

    //         try {

    //             if (!is_null($image) && $image->isValid()) {
    //                 $validated['image'] = $validated['id'] . '.' . strtolower($image->getClientOriginalExtension());
    //                 $this->findingService->updateWithImage($image, $validated);
    //                 Log::info('finding of ' . (!is_null($validated['equipment']) ? $validated['equipment'] : 'equipment not set') . ' ' . $validated['area'] . ' was updated with image', ['user' => session('user')]);
    //             } else {
    //                 Log::info('finding of ' . (!is_null($validated['equipment']) ? $validated['equipment'] : 'equipment not set') . ' ' . $validated['area'] . ' was updated without image', ['user' => session('user')]);
    //                 $this->findingService->update($validated);
    //             }
    //             return redirect()->back()->with('alert', ['message' => 'The finding successfully updated.', 'variant' => 'alert-success'])->withInput();
    //         } catch (Exception $error) {
    //             Log::error('finding of ' . (!is_null($validated['equipment']) ? $validated['equipment'] : 'equipment not set') . ' ' . $validated['area'] . ' error', ['user' => session('user'), 'message' => $error->getMessage()]);
    //             return redirect()->back()->withErrors($error->getMessage())->withInput();
    //         }
    //     } else {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }
    // }

    public function findingUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'exists:App\Models\Finding,id'],
            'area' => ['required', Rule::in($this->areas())],
            'department' => ['required', Rule::in($this::$departments)],
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
