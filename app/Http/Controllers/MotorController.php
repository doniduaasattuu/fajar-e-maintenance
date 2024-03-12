<?php

namespace App\Http\Controllers;

use App\Data\Alert;
use App\Data\Modal;
use App\Models\Motor;
use App\Rules\SameAsUnique;
use App\Services\FunclocService;
use App\Services\MotorDetailService;
use App\Services\MotorService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MotorController extends Controller
{
    private MotorService $motorService;
    private FunclocService $funclocService;
    private MotorDetailService $motorDetailService;

    public function __construct(
        MotorService $motorService,
        FunclocService $funclocService,
        MotorDetailService $motorDetailService,
    ) {
        $this->motorService = $motorService;
        $this->funclocService = $funclocService;
        $this->motorDetailService = $motorDetailService;
    }

    public function motors(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $paginator = Motor::query()
            ->when($search, function ($query, $search) {
                $query
                    ->where('id', 'LIKE', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                $query
                    ->where('status', '=', $status);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(800)
            ->withQueryString();

        return view('maintenance.motor.motor', [
            'title' => 'Motors',
            'paginator' => $paginator,
        ]);
    }

    public function motorEdit(string $id)
    {
        $motor = Motor::query()->with(['MotorDetail'])->find($id);

        if (is_null($motor)) {
            return back()->with('modal', new Modal('[404] Not found', "The motor $id is unregistered."));
        }

        return response()->view('maintenance.motor.form', [
            'title' => 'Edit motor',
            'action' => 'motor-update',
            'motor' => $motor,
            'motorDetail' => $motor->MotorDetail,
        ]);
    }

    public function motorDetails(string $id)
    {
        $motor = Motor::query()->with(['MotorDetail'])->find($id);

        if (is_null($motor)) {
            return back()->with('modal', new Modal('[404] Not found', "The motor $id is unregistered."));
        }

        return response()->view('maintenance.motor.form', [
            'title' => 'Motor details',
            'motor' => $motor,
        ]);
    }

    public function motorUpdate(Request $request)
    {

        $rules = [
            'id' => ['required', 'size:9', 'exists:App\Models\Motor,id'],
            'status' => ['required', Rule::in($this->getEnumValue('equipment', 'status'))],
            'funcloc' => ['nullable', 'prohibited_if:status,Available', 'prohibited_if:status,Repaired', 'required_if:status,Installed', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', 'exists:App\Models\Funcloc,id'],
            'sort_field' => ['nullable', 'prohibited_if:status,Available', 'prohibited_if:status,Repaired', 'required_if:status,Installed', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\#]+$/u'],
            'description' => ['nullable', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\;\,\#\=]+$/u'],
            'material_number' => ['nullable', 'digits:8', 'numeric'],
            'unique_id' => ['required', 'numeric', 'exists:App\Models\Motor,unique_id'],
            'qr_code_link' => ['required', 'exists:App\Models\Motor,qr_code_link', new SameAsUnique($request->input('unique_id'))],
            'motor_detail' => ['required', 'same:id'],
            'manufacturer' => ['nullable', 'max:50'],
            'serial_number' => ['nullable', 'max:50'],
            'type' => ['nullable', 'max:50'],
            'power_rate' => ['nullable', 'max:10'],
            'power_unit' => ['nullable', Rule::in($this->getEnumValue('motor', 'power_unit'))],
            'voltage' => ['nullable', 'max:10'],
            'electrical_current' => ['nullable', Rule::in($this->getEnumValue('motor', 'electrical_current'))],
            'current_nominal' => ['nullable', 'max:10'],
            'frequency' => ['nullable', 'max:10'],
            'pole' => ['nullable', 'max:10'],
            'rpm' => ['nullable', 'max:10'],
            'bearing_de' => ['nullable', 'max:25'],
            'bearing_nde' => ['nullable', 'max:25'],
            'frame_type' => ['nullable', 'max:25'],
            'shaft_diameter' => ['nullable', 'max:10'],
            'phase_supply' => ['nullable', 'max:3', 'numeric', 'digits_between:1,3'],
            'cos_phi' => ['nullable', 'max:10'],
            'efficiency' => ['nullable', 'max:10'],
            'ip_rating' => ['nullable', 'max:10'],
            'insulation_class' => ['nullable', 'max:10'],
            'duty' => ['nullable', 'max:10'],
            'connection_type' => ['nullable', 'max:25'],
            'nipple_grease' => ['nullable', Rule::in($this->getEnumValue('motor', 'nipple_grease'))],
            'greasing_type' => ['nullable', 'max:25'],
            'greasing_qty_de' => ['nullable', 'max:10'],
            'greasing_qty_nde' => ['nullable', 'max:10'],
            'length' => ['nullable', 'max:10'],
            'width' => ['nullable', 'max:10'],
            'height' => ['nullable', 'max:10'],
            'weight' => ['nullable', 'max:10'],
            'cooling_fan' => ['nullable', Rule::in($this->getEnumValue('motor', 'cooling_fan'))],
            'mounting' => ['nullable', Rule::in($this->getEnumValue('motor', 'mounting'))],
        ];

        $validator = Validator($request->all(), $rules);
        $validated_motor = $validator->safe()->except($this->getColumns('motor_details', ['id']));
        $validated_motor_details = $validator->safe()->merge(['motor_detail' => $validated_motor['id']])->except($this->getColumns('motors'));

        DB::beginTransaction();
        try {
            $this->motorService->updateMotor($validated_motor);
            $this->motorDetailService->updateMotorDetail($validated_motor_details);
        } catch (Exception $error) {
            DB::rollBack();
            Log::error('motor tries to updated', ['motor' => $validated_motor['id'], 'admin' => Auth::user()->fullname, 'message' => $error->getMessage()]);
            return back()->with('alert', new Alert($error->getMessage(), 'alert-danger'));
        }

        DB::commit();
        Log::info('motor updated success', ['motor' => $validated_motor['id'], 'admin' => Auth::user()->fullname]);
        return back()->with('alert', new Alert('The motor successfully updated.', 'alert-success'));
    }

    public function motorRegistration()
    {
        return response()->view('maintenance.motor.form', [
            'title' => 'Motor registration',
            'action' => 'motor-register'
        ]);
    }

    public function motorRegister(Request $request)
    {
        $rules = [
            'id' => ['required', 'regex:/^[a-zA-Z\d]+$/u', 'size:9', 'starts_with:EMO,MGM,MGB,MDO,MFB', Rule::notIn($this->motorService->registeredMotors())],
            'status' => ['required', Rule::in($this->getEnumValue('equipment', 'status'))],
            'funcloc' => ['nullable', 'prohibited_if:status,Available', 'prohibited_if:status,Repaired', 'required_if:status,Installed', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', Rule::in($this->funclocService->registeredFunclocs())],
            'sort_field' => ['nullable', 'prohibited_if:status,Available', 'prohibited_if:status,Repaired', 'required_if:status,Installed', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\#]+$/u'],
            'description' => ['nullable', 'min:3', 'max:50', 'regex:/^[a-zA-Z\s\.\d\/\-\;\,\#\=]+$/u'],
            'material_number' => ['nullable', 'numeric', 'digits:8'],
            'unique_id' => ['required', 'numeric', Rule::notIn($this->motorService->registeredUniqueIds())],
            'qr_code_link' => ['required', 'starts_with:id=Fajar-MotorList', Rule::notIn($this->motorService->registeredQrCodeLinks()), new SameAsUnique($request->input('unique_id'))],

            'manufacturer' => ['nullable', 'max:50'],
            'serial_number' => ['nullable', 'max:50'],
            'type' => ['nullable', 'max:50'],
            'power_rate' => ['nullable', 'max:10'],
            'power_unit' => ['nullable', Rule::in($this->getEnumValue('motor', 'power_unit'))],
            'voltage' => ['nullable', 'max:10'],
            'electrical_current' => ['nullable', Rule::in($this->getEnumValue('motor', 'electrical_current'))],
            'current_nominal' => ['nullable', 'max:10'],
            'frequency' => ['nullable', 'max:10'],
            'pole' => ['nullable', 'max:10'],
            'rpm' => ['nullable', 'max:10'],
            'bearing_de' => ['nullable', 'max:25'],
            'bearing_nde' => ['nullable', 'max:25'],
            'frame_type' => ['nullable', 'max:25'],
            'shaft_diameter' => ['nullable', 'max:10'],
            'phase_supply' => ['nullable', 'max:3', 'numeric', 'digits_between:1,3'],
            'cos_phi' => ['nullable', 'max:10'],
            'efficiency' => ['nullable', 'max:10'],
            'ip_rating' => ['nullable', 'max:10'],
            'insulation_class' => ['nullable', 'max:10'],
            'duty' => ['nullable', 'max:10'],
            'connection_type' => ['nullable', 'max:25'],
            'nipple_grease' => ['nullable', Rule::in($this->getEnumValue('motor', 'nipple_grease'))],
            'greasing_type' => ['nullable', 'max:25'],
            'greasing_qty_de' => ['nullable', 'max:10'],
            'greasing_qty_nde' => ['nullable', 'max:10'],
            'length' => ['nullable', 'max:10'],
            'width' => ['nullable', 'max:10'],
            'height' => ['nullable', 'max:10'],
            'weight' => ['nullable', 'max:10'],
            'cooling_fan' => ['nullable', Rule::in($this->getEnumValue('motor', 'cooling_fan'))],
            'mounting' => ['nullable', Rule::in($this->getEnumValue('motor', 'mounting'))],
        ];

        $validator = Validator::make($request->all(), $rules);

        $validated_motor = $validator->safe()->except($this->getColumns('motor_details', ['id']));
        $validated_motor_details = $validator->safe()->merge(['motor_detail' => $validated_motor['id']])->except($this->getColumns('motors'));

        DB::beginTransaction();
        try {
            $this->motorService->register($validated_motor);
            $this->motorDetailService->register($validated_motor_details);
        } catch (Exception $error) {
            DB::rollBack();
            Log::error('motor registration error', ['motor' => $validated_motor['id'], 'admin' => Auth::user()->fullname, 'message' => $error->getMessage()]);
            return back()->with('alert', new Alert($error->getMessage(), 'alert-danger'))->withInput();
        }

        DB::commit();
        return back()->with('alert', new Alert('The motor successfully registered.', 'alert-success', 'motor-edit/' .  $validated_motor['id']));
    }

    public function motorInstallDismantle()
    {
        return response()->view('maintenance.install-dismantle', [
            'title' => 'Install dismantle',
            'table' => 'Motors',
        ]);
    }

    public function equipmentMotor(Request $request)
    {
        $equipment = $request->input('equipment');
        $status = $request->input('status');

        $motor = Motor::query()->with(['MotorDetail'])->find($equipment);

        if (!is_null($motor)) {
            if ($motor->status == $status) {
                return response()->json($motor);
            } else {
                return response()->json(null);
            }
        } else {
            return response()->json($motor);
        }
    }

    public function doMotorInstallDismantle(Request $request)
    {
        $rules = [
            'id_dismantle' => ['required', 'size:9', 'different:id_install', Rule::in($this->motorService->registeredMotors())],
            'id_install' => ['required', 'size:9', 'different:id_dismantle', Rule::in($this->motorService->registeredMotors())],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated = $validator->validated();
            $dismantle = $validated['id_dismantle'];
            $install = $validated['id_install'];

            try {
                $this->motorService->installDismantle($dismantle, $install);
            } catch (Exception $error) {
                Log::error('motor install dismantle error', ['motor_dismantle' => $dismantle, 'motor_install' => $install, 'admin' => Auth::user()->fullname, 'message' => $error->getMessage()]);
                return back()->with('modal', new Modal('[500] Internal Server Error', $error->getMessage()));
            }

            Log::info('motor install dismantle success', ['motor_dismantle' => $dismantle, 'motor_install' => $install, 'admin' => Auth::user()->fullname]);
            return back()->with('modal', new Modal('[200] Success', 'The motor was successfully swapped.'));
        } else {
            return back()->with('modal', new Modal('[403] Forbidden', $validator->errors()->first()));
        }
    }
}
