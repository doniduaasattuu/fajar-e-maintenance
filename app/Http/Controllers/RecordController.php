<?php

namespace App\Http\Controllers;

use App\Data\Alert;
use App\Data\Modal;
use App\Models\Finding;
use App\Models\Motor;
use App\Models\MotorRecord;
use App\Models\Trafo;
use App\Models\TrafoRecord;
use App\Services\FindingService;
use App\Services\MotorService;
use App\Services\TrafoService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class RecordController extends Controller
{
    private MotorService $motorService;
    private FindingService $findingService;
    private TrafoService $trafoService;

    public function __construct(
        MotorService $motorService,
        FindingService $findingService,
        TrafoService $trafoService,

    ) {
        $this->motorService = $motorService;
        $this->findingService = $findingService;
        $this->trafoService = $trafoService;
    }

    public function checkingForm(string $equipment_id)
    {
        $equipment_type = $this->getEquipmentType($equipment_id);

        if ($equipment_type == 'Fajar-MotorList') {

            $unique_id = $this->getEquipmentUniqueId($equipment_id);
            $motor = Motor::query()->with(['MotorDetail'])->where('unique_id', '=', $unique_id)->first();

            if (!is_null($motor)) {

                return view('maintenance.motor.checking-form', [
                    'title' => 'Checking form',
                    'motorService' => $this->motorService,
                    'motor' => $motor,
                    'motorDetail' => $motor->MotorDetail,
                    'action' => route('motor-record'),
                ]);
            } else {
                return back()->with('modal', new Modal('[404] Not found', "The motor with id $unique_id was not found."));
            }
        } else if ($equipment_type == 'Fajar-TrafoList') {

            $unique_id = $this->getEquipmentUniqueId($equipment_id);
            $trafo = Trafo::query()->with(['TrafoDetail'])->where('unique_id', '=', $unique_id)->first();

            if (!is_null($trafo)) {

                return response()->view('maintenance.trafo.checking-form', [
                    'title' => 'Checking form',
                    'trafoService' => $this->trafoService,
                    'trafo' => $trafo,
                    'trafoDetail' => $trafo->TrafoDetail,
                    'action' => route('trafo-record'),
                ]);
            } else {
                return back()->with('modal', new Modal('[404] Not found', "The trafo with id $unique_id was not found."));
            }
        } else {
            return back()->with('modal', new Modal('[404] Not found', "The equipment was not found."));
        }
    }

    public function saveRecordMotor(Request $request)
    {
        $request->merge(['id' => uniqid()]);

        $validated = $request->validate([
            'id' => ['required', 'size:13'],
            'funcloc' => ['required', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', 'exists:App\Models\Funcloc,id'],
            'motor' => ['required', 'size:9', 'exists:App\Models\Motor,id'],
            'sort_field' => ['required'],
            'motor_status' => ['required', Rule::in($this->motorService->motorStatusEnum())],
            'cleanliness' => ['required', Rule::in($this->motorService->cleanlinessEnum())],
            'nipple_grease' => ['required', Rule::in($this->motorService->nippleGreaseEnum())],
            'number_of_greasing' => ['nullable', 'integer', 'max:255', 'prohibited_if:nipple_grease,Not Available'],
            'temperature_de' => ['nullable', 'decimal:0,2', 'min:15', 'max:255'],
            'temperature_body' => ['nullable', 'decimal:0,2', 'min:15', 'max:255'],
            'temperature_nde' => ['nullable', 'decimal:0,2', 'min:15', 'max:255'],
            'vibration_de_vertical_value' => ['nullable', 'decimal:0,2', 'min:0', 'max:45'],
            'vibration_de_vertical_desc' => ['required', Rule::in($this->motorService->vibrationDescriptionEnum())],
            'vibration_de_horizontal_value' => ['nullable', 'decimal:0,2', 'min:0', 'max:45'],
            'vibration_de_horizontal_desc' => ['required', Rule::in($this->motorService->vibrationDescriptionEnum())],
            'vibration_de_axial_value' => ['nullable', 'decimal:0,2', 'min:0', 'max:45'],
            'vibration_de_axial_desc' => ['required', Rule::in($this->motorService->vibrationDescriptionEnum())],
            'vibration_de_frame_value' => ['nullable', 'decimal:0,2', 'min:0', 'max:45'],
            'vibration_de_frame_desc' => ['required', Rule::in($this->motorService->vibrationDescriptionEnum())],
            'noise_de' => ['required', Rule::in($this->motorService->noiseEnum())],
            'vibration_nde_vertical_value' => ['nullable', 'decimal:0,2', 'min:0', 'max:45'],
            'vibration_nde_vertical_desc' => ['required', Rule::in($this->motorService->vibrationDescriptionEnum())],
            'vibration_nde_horizontal_value' => ['nullable', 'decimal:0,2', 'min:0', 'max:45'],
            'vibration_nde_horizontal_desc' => ['required', Rule::in($this->motorService->vibrationDescriptionEnum())],
            'vibration_nde_frame_value' => ['nullable', 'decimal:0,2', 'min:0', 'max:45'],
            'vibration_nde_frame_desc' => ['required', Rule::in($this->motorService->vibrationDescriptionEnum())],
            'noise_nde' => ['required', Rule::in($this->motorService->noiseEnum())],
            'nik' => ['required', 'digits:8', 'numeric', 'exists:App\Models\User,nik'],
            'finding_description' => ['nullable', 'min:15'],
            'finding_image' => ['nullable', 'prohibited_if:finding_description,null', 'max:5000', File::types(['png', 'jpeg', 'jpg'])],
        ]);

        DB::beginTransaction();

        try {
            $validated_record = Arr::except($validated, ['finding_description', 'finding_image']);
            $record = MotorRecord::create($validated_record);
            $record->save();
            Log::info('record ' . $validated['motor'] . ' inserted', ['checker' => Auth::user()->fullname]);

            $image = $request->file('finding_image');
            $validated_finding = [
                'id' => $validated['id'],
                'area' => explode('-', $validated['funcloc'])[2],
                'department' => Auth::user()->department,
                'description' => $validated['finding_description'],
                'equipment' => $validated['motor'],
                'funcloc' => $validated['funcloc'],
                'reporter' => Auth::user()->abbreviated_name,
            ];

            if (!empty($validated['finding_description'])) {

                if (!is_null($image) && $image->isValid()) {
                    $validated_finding['image'] = $validated['id'] . '.' . $image->getClientOriginalExtension();
                    $this->findingService->insertWithImage($image, $validated_finding);
                    Log::info('record ' . $validated['motor'] . ' with finding description and image inserted', ['checker' => Auth::user()->fullname]);
                } else {
                    $this->findingService->insert($validated_finding);
                    Log::info('record ' . $validated['motor'] . ' with finding description inserted', ['checker' => Auth::user()->fullname]);
                }
            }
        } catch (Exception $error) {
            DB::rollback();
            return back()->with('alert', new Alert($error->getMessage(), 'alert-danger'))->withInput();
        }

        DB::commit();
        return back()->with('alert', new Alert('The motor record successfully saved.', 'alert-success', 'record-edit/motor/' .  $validated_record['id']));
    }

    public function editRecordMotor(string $uniqid)
    {
        $record = MotorRecord::query()->find($uniqid);
        $finding = Finding::query()->find($uniqid);

        $motor = Motor::query()->with(['MotorDetail'])->find($record->motor);

        if (!is_null($record)) {

            return response()->view('maintenance.motor.checking-form', [
                'title' => 'Motor record edit',
                'motorService' => $this->motorService,
                'record' => $record,
                'motor' => $motor,
                'motorDetail' => $motor->MotorDetail,
                'finding' => $finding,
                'action' => '/' . request()->path(),
            ]);
        } else {
            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The record $uniqid is not found."]);
        }
    }

    public function updateRecordMotor(Request $request, string $record_id)
    {
        $record = MotorRecord::find($record_id);
        $record->update($request->all());

        $validated = $request->validate([
            'id' => ['required', 'size:13'],
            'funcloc' => ['required', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', 'exists:App\Models\Funcloc,id'],
            'motor' => ['required', 'size:9', 'exists:App\Models\Motor,id'],
            'sort_field' => ['required'],
            'motor_status' => ['required', Rule::in($this->motorService->motorStatusEnum())],
            'cleanliness' => ['required', Rule::in($this->motorService->cleanlinessEnum())],
            'nipple_grease' => ['required', Rule::in($this->motorService->nippleGreaseEnum())],
            'number_of_greasing' => ['nullable', 'integer', 'max:255', 'prohibited_if:nipple_grease,Not Available'],
            'temperature_de' => ['nullable', 'decimal:0,2', 'min:15', 'max:255'],
            'temperature_body' => ['nullable', 'decimal:0,2', 'min:15', 'max:255'],
            'temperature_nde' => ['nullable', 'decimal:0,2', 'min:15', 'max:255'],
            'vibration_de_vertical_value' => ['nullable', 'decimal:0,2', 'min:0', 'max:45'],
            'vibration_de_vertical_desc' => ['required', Rule::in($this->motorService->vibrationDescriptionEnum())],
            'vibration_de_horizontal_value' => ['nullable', 'decimal:0,2', 'min:0', 'max:45'],
            'vibration_de_horizontal_desc' => ['required', Rule::in($this->motorService->vibrationDescriptionEnum())],
            'vibration_de_axial_value' => ['nullable', 'decimal:0,2', 'min:0', 'max:45'],
            'vibration_de_axial_desc' => ['required', Rule::in($this->motorService->vibrationDescriptionEnum())],
            'vibration_de_frame_value' => ['nullable', 'decimal:0,2', 'min:0', 'max:45'],
            'vibration_de_frame_desc' => ['required', Rule::in($this->motorService->vibrationDescriptionEnum())],
            'noise_de' => ['required', Rule::in($this->motorService->noiseEnum())],
            'vibration_nde_vertical_value' => ['nullable', 'decimal:0,2', 'min:0', 'max:45'],
            'vibration_nde_vertical_desc' => ['required', Rule::in($this->motorService->vibrationDescriptionEnum())],
            'vibration_nde_horizontal_value' => ['nullable', 'decimal:0,2', 'min:0', 'max:45'],
            'vibration_nde_horizontal_desc' => ['required', Rule::in($this->motorService->vibrationDescriptionEnum())],
            'vibration_nde_frame_value' => ['nullable', 'decimal:0,2', 'min:0', 'max:45'],
            'vibration_nde_frame_desc' => ['required', Rule::in($this->motorService->vibrationDescriptionEnum())],
            'noise_nde' => ['required', Rule::in($this->motorService->noiseEnum())],
            'nik' => ['required', 'digits:8', 'numeric', 'exists:App\Models\User,nik'],
            'finding_description' => ['nullable', 'min:15'],
            'finding_image' => ['nullable', 'prohibited_if:finding_description,null', 'max:5000', File::types(['png', 'jpeg', 'jpg'])],
        ]);

        DB::beginTransaction();

        try {
            $validated_record = Arr::except($validated, ['finding_description', 'finding_image']);
            $record->update($validated_record);
            Log::info('record ' . $validated['motor'] . ' updated', ['checker' => Auth::user()->fullname]);

            $finding = Finding::find($record_id);
            $image = $request->file('finding_image');
            if (!is_null($image) && $image->isValid()) {

                $validated_finding = [
                    'id' => $validated['id'],
                    'area' => explode('-', $validated['funcloc'])[2],
                    'department' => Auth::user()->department,
                    'description' => $validated['finding_description'],
                    'equipment' => $validated['motor'],
                    'funcloc' => $validated['funcloc'],
                    'reporter' => Auth::user()->abbreviated_name,
                ];

                if (!is_null($finding)) {
                    $finding->update($validated_finding);
                } else {
                    $finding = Finding::create($validated_finding);
                    $finding->save();
                }

                $validated_finding['image'] = $validated['id'] . '.' . $image->getClientOriginalExtension();
                $this->findingService->updateWithImage($image, $validated_finding);
            } else if (!empty($finding->description)) {
                if ($finding->description != $validated['finding_description']) {
                    $finding->update([
                        'finding_description' => $validated['finding_description'],
                    ]);
                }
            }

            DB::commit();
        } catch (Exception $error) {
            DB::rollback();
            return back()->with('alert', new Alert($error->getMessage(), 'alert-danger'))->withInput();
        }

        return back()->with('alert', new Alert('The motor record successfully updated.', 'alert-success'))->withInput();
    }

    public function saveRecordTrafo(Request $request)
    {
        $request->merge(['id' => uniqid()]);

        $validated = $request->validate([
            'id' => ['required', 'size:13'],
            'funcloc' => ['required', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', 'exists:App\Models\Funcloc,id'],
            'trafo' => ['required', 'size:9', 'exists:App\Models\Trafo,id'],
            'sort_field' => ['required'],
            'trafo_status' => ['required', Rule::in($this->trafoService->trafoStatusEnum)],
            'primary_current_phase_r' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
            'primary_current_phase_s' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
            'primary_current_phase_t' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
            'secondary_current_phase_r' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
            'secondary_current_phase_s' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
            'secondary_current_phase_t' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
            'primary_voltage' => ['nullable', 'decimal:0,2', 'min:0', 'max:999999'],
            'secondary_voltage' => ['nullable', 'decimal:0,2', 'min:0', 'max:999999'],
            'oil_temperature' => ['nullable', 'decimal:0,2', 'min:15', 'max:255'],
            'winding_temperature' => ['nullable', 'decimal:0,2', 'min:15', 'max:255'],
            'cleanliness' => ['required', Rule::in($this->trafoService->cleanlinessEnum)],
            'noise' => ['required', Rule::in($this->trafoService->noiseEnum)],
            'silica_gel' => ['required', Rule::in(['Good', 'Satisfactory', 'Unsatisfactory', 'Unacceptable'])],
            'earthing_connection' => ['required', Rule::in($this->trafoService->earthingConnectionEnum)],
            'oil_leakage' => ['required', Rule::in($this->trafoService->oilLeakageEnum)],
            'oil_level' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'blower_condition' => ['required', Rule::in($this->trafoService->blowerConditionEnum)],
            'nik' => ['required', 'digits:8', 'numeric', 'exists:App\Models\User,nik'],
            'finding_description' => ['nullable', 'min:15'],
            'finding_image' => ['nullable', 'prohibited_if:finding_description,null', 'max:5000', File::types(['png', 'jpeg', 'jpg'])],
        ]);

        DB::beginTransaction();

        try {
            $validated_record = Arr::except($validated, ['finding_description', 'finding_image']);
            $record = TrafoRecord::create($validated_record);
            $record->save();
            Log::info('record ' . $validated['trafo'] . ' inserted', ['checker' => Auth::user()->fullname]);

            $image = $request->file('finding_image');
            $validated_finding = [
                'id' => $validated['id'],
                'area' => explode('-', $validated['funcloc'])[2],
                'department' => Auth::user()->department,
                'description' => $validated['finding_description'],
                'equipment' => $validated['trafo'],
                'funcloc' => $validated['funcloc'],
                'reporter' => Auth::user()->abbreviated_name,
            ];

            if (!empty($validated['finding_description'])) {

                if (!is_null($image) && $image->isValid()) {
                    $validated_finding['image'] = $validated['id'] . '.' . $image->getClientOriginalExtension();
                    $this->findingService->insertWithImage($image, $validated_finding);
                    Log::info('record ' . $validated['trafo'] . ' with finding description and image inserted', ['checker' => Auth::user()->fullname]);
                } else {
                    $this->findingService->insert($validated_finding);
                    Log::info('record ' . $validated['trafo'] . ' with finding description inserted', ['checker' => Auth::user()->fullname]);
                }
            }

            DB::commit();
        } catch (Exception $error) {
            DB::rollback();
            return back()->with('alert', new Alert($error->getMessage(), 'alert-danger'))->withInput();
        }

        return back()->with('alert', new Alert('The trafo record successfully saved.', 'alert-success', 'record-edit/trafo/' .  $validated_record['id']));
    }

    public function editRecordTrafo(string $uniqid)
    {
        $record = TrafoRecord::query()->find($uniqid);
        $finding = Finding::query()->find($uniqid);

        $trafo = Trafo::query()->with(['TrafoDetail'])->find($record->trafo);

        if (!is_null($record)) {

            return response()->view('maintenance.trafo.checking-form', [
                'title' => 'Trafo record edit',
                'trafoService' => $this->trafoService,
                'record' => $record,
                'trafo' => $trafo,
                'trafoDetail' => $trafo->trafoDetail,
                'finding' => $finding,
                'action' => '/' . request()->path(),
            ]);
        } else {
            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The record $uniqid is not found."]);
        }
    }

    public function updateRecordTrafo(Request $request, string $record_id)
    {
        $record = TrafoRecord::find($record_id);
        $record->update($request->all());

        $validated = $request->validate([
            'id' => ['required', 'size:13'],
            'funcloc' => ['required', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', 'exists:App\Models\Funcloc,id'],
            'trafo' => ['required', 'size:9', 'exists:App\Models\Trafo,id'],
            'sort_field' => ['required'],
            'trafo_status' => ['required', Rule::in($this->trafoService->trafoStatusEnum)],
            'primary_current_phase_r' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
            'primary_current_phase_s' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
            'primary_current_phase_t' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
            'secondary_current_phase_r' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
            'secondary_current_phase_s' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
            'secondary_current_phase_t' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
            'primary_voltage' => ['nullable', 'decimal:0,2', 'min:0', 'max:999999'],
            'secondary_voltage' => ['nullable', 'decimal:0,2', 'min:0', 'max:999999'],
            'oil_temperature' => ['nullable', 'decimal:0,2', 'min:15', 'max:255'],
            'winding_temperature' => ['nullable', 'decimal:0,2', 'min:15', 'max:255'],
            'cleanliness' => ['required', Rule::in($this->trafoService->cleanlinessEnum)],
            'noise' => ['required', Rule::in($this->trafoService->noiseEnum)],
            'silica_gel' => ['required', Rule::in(['Good', 'Satisfactory', 'Unsatisfactory', 'Unacceptable'])],
            'earthing_connection' => ['required', Rule::in($this->trafoService->earthingConnectionEnum)],
            'oil_leakage' => ['required', Rule::in($this->trafoService->oilLeakageEnum)],
            'oil_level' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'blower_condition' => ['required', Rule::in($this->trafoService->blowerConditionEnum)],
            'nik' => ['required', 'digits:8', 'numeric', 'exists:App\Models\User,nik'],
            'finding_description' => ['nullable', 'min:15'],
            'finding_image' => ['nullable', 'prohibited_if:finding_description,null', 'max:5000', File::types(['png', 'jpeg', 'jpg'])],
        ]);

        DB::beginTransaction();

        try {
            $validated_record = Arr::except($validated, ['finding_description', 'finding_image']);
            $record->update($validated_record);

            $finding = Finding::find($record_id);
            $image = $request->file('finding_image');
            if (!is_null($image) && $image->isValid()) {

                $validated_finding = [
                    'id' => $validated['id'],
                    'area' => explode('-', $validated['funcloc'])[2],
                    'department' => Auth::user()->department,
                    'description' => $validated['finding_description'],
                    'equipment' => $validated['trafo'],
                    'funcloc' => $validated['funcloc'],
                    'reporter' => Auth::user()->abbreviated_name,
                ];

                if (!is_null($finding)) {
                    $finding->update($validated_finding);
                } else {
                    $finding = Finding::create($validated_finding);
                    $finding->save();
                }

                $validated_finding['image'] = $validated['id'] . '.' . $image->getClientOriginalExtension();
                $this->findingService->updateWithImage($image, $validated_finding);
            } else if (!empty($finding->description)) {
                if ($finding->description != $validated['finding_description']) {
                    $finding->update([
                        'finding_description' => $validated['finding_description'],
                    ]);
                }
            }

            DB::commit();
        } catch (Exception $error) {
            DB::rollback();
            return back()->with('alert', new Alert($error->getMessage(), 'alert-danger'))->withInput();
        }

        return back()->with('alert', new Alert('The trafo record successfully updated.', 'alert-success'))->withInput();
    }
}
