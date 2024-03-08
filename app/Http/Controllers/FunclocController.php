<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Funcloc;
use App\Services\FunclocService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FunclocController extends Controller
{
    private FunclocService $funclocService;

    public function __construct(FunclocService $funclocService)
    {
        $this->funclocService = $funclocService;
    }

    // public function funclocs(?string $page = '1', ?string $filter = null)
    // {
    //     $paginate = DB::table('funclocs')
    //         ->orderBy('updated_at', 'desc')
    //         ->paginate(perPage: 1000, page: $page);

    //     return response()->view('maintenance.funcloc.funcloc', [
    //         'title' => 'Table funcloc',
    //         'funclocService' => $this->funclocService,
    //         'paginate' => $paginate,
    //         'filter' => $filter,
    //     ]);
    // }

    public function funclocs(Request $request)
    {
        $search = $request->query('search');

        $paginator = Funcloc::query()
            ->when($search, function ($query, $search) {
                $query
                    ->where('id', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(50)
            ->withQueryString();

        return view('maintenance.funcloc.funcloc', [
            'title' => 'Funclocs',
            'paginator' => $paginator,
        ]);
    }

    public function funclocEdit(string $id)
    {
        $funcloc = Funcloc::query()->find($id);

        if (is_null($funcloc)) {
            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The funcloc $id is unregistered."]);
        }

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
            'id' => ['required', 'regex:/^[A-Z\d\-]+$/u', 'starts_with:FP-01', 'min:9', 'max:50', 'exists:App\Models\Funcloc,id'],
            'description' => ['nullable', 'min:3', 'max:50', 'regex:/^[A-Z\s\.\d\/\-\#]+$/u'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated = $validator->validated();

            try {
                $this->funclocService->updateFuncloc($validated);
            } catch (Exception $error) {
                Log::error('funcloc tries to updated', ['funcloc' => $validated['id'], 'admin' => session('user'), 'message' => $error->getMessage()]);
                return redirect()->back()->with('alert', ['message' => $error->getMessage(), 'variant' => 'alert-danger']);
            }

            Log::info('funcloc updated success', ['funcloc' => $validated['id'], 'admin' => session('user')]);
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
            'id' => ['required', 'regex:/^[A-Z\d\-]+$/u', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', Rule::notIn($this->funclocService->registeredFunclocs())],
            'description' => ['nullable', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\#]+$/u'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated = $validator->validated();

            try {
                $this->funclocService->register($validated);
            } catch (Exception $error) {
                Log::error('funcloc registration error', ['funcloc' => $validated['id'], 'admin' => session('user'), 'message' => $error->getMessage()]);
                return redirect()->back()->with('alert', ['message' => $error->getMessage(), 'variant' => 'alert-danger']);
            }

            Log::info('funcloc register success', ['funcloc' => $validated['id'], 'admin' => session('user')]);
            return redirect()->back()->with('alert', ['message' => 'The funcloc successfully registered.', 'variant' => 'alert-success']);
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}
