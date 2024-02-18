<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Finding;
use App\Models\User;
use App\Services\FindingService;
use App\Services\FunclocService;
use App\Services\MotorService;
use App\Services\TrafoService;
use App\Services\UserService;
use App\Traits\Utility;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class FindingController extends Controller
{

    use Utility;
    private FindingService $findingService;
    private FunclocService $funclocService;
    private MotorService $motorService;
    private TrafoService $trafoService;
    private UserService $userService;

    public function __construct(
        FindingService $findingService,
        FunclocService $funclocService,
        MotorService $motorService,
        TrafoService $trafoService,
        UserService $userService,
    ) {
        $this->findingService = $findingService;
        $this->funclocService = $funclocService;
        $this->motorService = $motorService;
        $this->trafoService = $trafoService;
        $this->userService = $userService;
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
            'title' => 'New finding',
            'findingService' => $this->findingService,
            'action' => 'finding-register'
        ]);
    }

    public function findingRegister(Request $request)
    {
        $request->mergeIfMissing(['id' => uniqid(), 'reporter' => User::query()->find(session('nik'))->fullname]);

        $rules = [
            'id' => ['required', 'size:13'],
            'area' => ['required', Rule::in($this->areas())],
            'status' => ['required', Rule::in($this->findingService->findingStatusEnum)],
            'equipment' => ['nullable', Rule::in(array_merge($this->motorService->registeredMotors(), $this->trafoService->registeredTrafos()))],
            'funcloc' => ['nullable', Rule::in($this->funclocService->registeredFunclocs())],
            'notification' => ['nullable', 'numeric', 'digits:8'],
            'reporter' => ['required', Rule::in($this->userService->registeredFullnames())],
            'description' => ['required', 'min:15'],
            'image' => ['nullable', 'prohibited_if:description,null', 'max:5000', File::types(['png', 'jpeg', 'jpg'])],

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            try {

                $image = $request->file('image');
                $validated = $validator->safe()->except(['image']);

                if (!is_null($image) && $image->isValid()) {
                    $validated['image'] = $validated['id'] . '.' . strtolower($image->getClientOriginalExtension());
                    $this->findingService->insertWithImage($image, $validated);
                    Log::info('finding of ' . (!is_null($validated['equipment']) ? $validated['equipment'] : 'equipment not set') . ' ' . $validated['area'] . ' with image was inserted', ['user' => session('user')]);
                } else {
                    Log::info('finding of ' . (!is_null($validated['equipment']) ? $validated['equipment'] : 'equipment not set') . ' ' . $validated['area'] . ' without image was inserted', ['user' => session('user')]);
                    $this->findingService->insert($validated);
                }
            } catch (Exception $error) {
                Log::error('finding of ' . (!is_null($validated['equipment']) ? $validated['equipment'] : 'equipment not set') . ' ' . $validated['area'], ['user' => session('user'), 'message' => $error->getMessage()]);
                return redirect()->back()->withErrors($error->getMessage())->withInput();
            }

            return redirect()->back()->with('alert', ['message' => 'The finding successfully saved.', 'variant' => 'alert-success']);
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
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
            return redirect()->back()->with('message', ['header' => '[404] Not found!', 'message' => 'Finding not found!.']);
        }
    }

    public function findingUpdate(Request $request)
    {
        $rules = [
            'id' => ['required', 'exists:App\Models\Finding,id'],
            'area' => ['required', Rule::in($this->areas())],
            'status' => ['required', Rule::in($this->findingService->findingStatusEnum)],
            'equipment' => ['nullable', Rule::in(array_merge($this->motorService->registeredMotors(), $this->trafoService->registeredTrafos()))],
            'funcloc' => ['nullable', Rule::in($this->funclocService->registeredFunclocs())],
            'notification' => ['nullable', 'numeric', 'digits:8'],
            'reporter' => ['required', Rule::in($this->userService->registeredFullnames())],
            'description' => ['required', 'min:15'],
            'image' => ['nullable', 'prohibited_if:description,null', 'max:5000', File::types(['png', 'jpeg', 'jpg'])],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated = $validator->validated();
            $image = $request->file('image');

            try {

                if (!is_null($image) && $image->isValid()) {
                    $validated['image'] = $validated['id'] . '.' . strtolower($image->getClientOriginalExtension());
                    $this->findingService->updateWithImage($image, $validated);
                    Log::info('finding of ' . (!is_null($validated['equipment']) ? $validated['equipment'] : 'equipment not set') . ' ' . $validated['area'] . ' was updated with image', ['user' => session('user')]);
                } else {
                    Log::info('finding of ' . (!is_null($validated['equipment']) ? $validated['equipment'] : 'equipment not set') . ' ' . $validated['area'] . ' was updated without image', ['user' => session('user')]);
                    $this->findingService->update($validated);
                }
                return redirect()->back()->with('alert', ['message' => 'The finding successfully updated.', 'variant' => 'alert-success'])->withInput();
            } catch (Exception $error) {
                Log::error('finding of ' . (!is_null($validated['equipment']) ? $validated['equipment'] : 'equipment not set') . ' ' . $validated['area'] . ' error', ['user' => session('user'), 'message' => $error->getMessage()]);
                return redirect()->back()->withErrors($error->getMessage())->withInput();
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function findingDelete(string $id)
    {
        $finding = Finding::query()->find($id);

        if (!is_null($finding)) {

            if (!is_null($finding->image)) {
                Storage::disk('public')->delete("findings/$finding->image");
            }

            $finding->delete();
            Log::info('finding of ' . (!is_null($finding['equipment']) ? $finding['equipment'] : $finding['id']) . ' ' . $finding['area'] . ' was deleted', ['user' => session('user')]);
            return redirect()->back()->with('message', ['header' => '[204] Success!', 'message' => 'Finding successfully deleted!.']);
        } else {
            return redirect()->back()->with('message', ['header' => '[404] Not found!', 'message' => 'Finding not found!.']);
        }
    }
}
