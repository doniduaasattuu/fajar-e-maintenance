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
use App\Services\MotorRecordService;
use App\Services\MotorService;
use App\Services\TrafoRecordService;
use App\Services\TrafoService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class RecordController extends Controller
{
    private MotorService $motorService;
    private MotorRecordService $motorRecordService;
    private FindingService $findingService;
    private TrafoService $trafoService;
    private TrafoRecordService $trafoRecordService;

    public function __construct(
        MotorService $motorService,
        MotorRecordService $motorRecordService,
        FindingService $findingService,
        TrafoService $trafoService,
        TrafoRecordService $trafoRecordService,
    ) {
        $this->motorService = $motorService;
        $this->motorRecordService = $motorRecordService;
        $this->findingService = $findingService;
        $this->trafoService = $trafoService;
        $this->trafoRecordService = $trafoRecordService;
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

            $image = $request->file('finding_image');
            $validated_finding = [
                'id' => $validated['id'],
                'area' => explode('-', $validated['funcloc'])[2],
                'description' => $validated['finding_description'],
                'equipment' => $validated['motor'],
                'funcloc' => $validated['funcloc'],
                'reporter' => Auth::user()->abbreviated_name,
            ];

            if (!empty($validated['finding_description'])) {

                if (!is_null($image) && $image->isValid()) {
                    $validated_finding['image'] = $validated['id'] . '.' . $image->getClientOriginalExtension();
                    $this->findingService->insertWithImage($image, $validated_finding);
                } else {
                    $this->findingService->insert($validated_finding);
                }
            }

            DB::commit();
        } catch (Exception $error) {
            DB::rollback();
            return back()->with('alert', new Alert($error->getMessage(), 'alert-danger'))->withInput();
        }

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

            $finding = Finding::find($record_id);
            $image = $request->file('finding_image');
            if (!is_null($image) && $image->isValid()) {

                $validated_finding = [
                    'id' => $validated['id'],
                    'area' => explode('-', $validated['funcloc'])[2],
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

    // TRAFO
    // public function saveRecordTrafo(Request $request)
    // {
    //     $request->mergeIfMissing(['id' => uniqid()]);
    //     $data = $request->all();

    //     $rules = [
    //         'id' => ['required', 'size:13'],
    //         'funcloc' => ['required', 'alpha_dash', 'starts_with:FP-01', 'min:9', 'max:50', 'exists:App\Models\Funcloc,id'],
    //         'trafo' => ['required', 'size:9', 'exists:App\Models\Trafo,id'],
    //         'sort_field' => ['required'],
    //         'trafo_status' => ['required', Rule::in($this->trafoService->trafoStatusEnum)],
    //         'primary_current_phase_r' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
    //         'primary_current_phase_s' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
    //         'primary_current_phase_t' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
    //         'secondary_current_phase_r' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
    //         'secondary_current_phase_s' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
    //         'secondary_current_phase_t' => ['nullable', 'prohibited_if:trafo_status,Offline', 'decimal:0,2', 'min:0', 'max:99999'],
    //         'primary_voltage' => ['nullable', 'decimal:0,2', 'min:0', 'max:999999'],
    //         'secondary_voltage' => ['nullable', 'decimal:0,2', 'min:0', 'max:999999'],
    //         'oil_temperature' => ['nullable', 'decimal:0,2', 'min:15', 'max:255'],
    //         'winding_temperature' => ['nullable', 'decimal:0,2', 'min:15', 'max:255'],
    //         'cleanliness' => ['required', Rule::in($this->trafoService->cleanlinessEnum)],
    //         'noise' => ['required', Rule::in($this->trafoService->noiseEnum)],
    //         'silica_gel' => ['required', Rule::in(['Good', 'Satisfactory', 'Unsatisfactory', 'Unacceptable'])],
    //         'earthing_connection' => ['required', Rule::in($this->trafoService->earthingConnectionEnum)],
    //         'oil_leakage' => ['required', Rule::in($this->trafoService->oilLeakageEnum)],
    //         'oil_level' => ['nullable', 'numeric', 'min:0', 'max:100'],
    //         'blower_condition' => ['required', Rule::in($this->trafoService->blowerConditionEnum)],
    //         'nik' => ['required', 'digits:8', 'numeric', Rule::in(session('nik')), 'exists:App\Models\User,nik'],
    //         'finding_description' => ['nullable', 'min:15'],
    //         'finding_image' => ['nullable', 'prohibited_if:finding_description,null', Rule::requiredIf(fn () => !is_null($request->input('finding_description'))), 'max:5000', File::types(['png', 'jpeg', 'jpg'])],
    //     ];

    //     $validator = Validator::make($data, $rules);

    //     if ($validator->passes()) {

    //         $validated = $validator->validated();
    //         $validated_record = $validator->safe()->except(['finding_description', 'finding_image']);
    //         $image = $request->file('finding_image');
    //         $validated_finding = [
    //             'id' => $validated['id'],
    //             'area' => explode('-', $validated['funcloc'])[2],
    //             'description' => $validated['finding_description'],
    //             'equipment' => $validated['trafo'],
    //             'funcloc' => $validated['funcloc'],
    //             'reporter' => User::query()->find($validated['nik'])->abbreviated_name,
    //         ];

    //         try {

    //             $record = TrafoRecord::query()->find($validated_record['id']);

    //             if (is_null($record)) {

    //                 // SAVE RECORD
    //                 $this->trafoRecordService->save($validated_record);
    //                 Log::info('record trafo ' . $validated['trafo'] . ' was inserted', ['checker' => session('user')]);

    //                 // SAVE FINDING
    //                 if (!empty($validated['finding_description']) && !is_null($validated['finding_description'])) {
    //                     if (!is_null($image) && $image->isValid()) {

    //                         Log::info('finding of ' . $validated['trafo'] . ' with description and image also inserted', ['checker' => session('user')]);
    //                         $validated_finding['image'] = $validated['id'] . '.' . $image->getClientOriginalExtension();
    //                         $this->findingService->insertWithImage($image, $validated_finding);
    //                     } else {
    //                         Log::info('finding of ' . $validated['trafo'] . ' with description and without image also inserted', ['checker' => session('user')]);
    //                         $this->findingService->insert($validated_finding);
    //                     }
    //                 }
    //             } else {

    //                 // UPDATE RECORD
    //                 $this->trafoRecordService->update($record, $validated_record);
    //                 Log::info('record trafo ' . $record['trafo'] . ' was updated', ['checker' => session('user')]);

    //                 // UPDATE FINDING
    //                 $finding = Finding::query()->find($validated['id']);

    //                 if (!empty($validated['finding_description']) && !is_null($validated['finding_description'])) {

    //                     if (is_null($finding)) {
    //                         if (!is_null($image) && $image->isValid()) {

    //                             Log::info('finding with description and image inserted on ' . $validated['trafo'] . ' update record', ['checker' => session('user')]);
    //                             $validated_finding['image'] = $validated['id'] . '.' . $image->getClientOriginalExtension();
    //                             $this->findingService->insertWithImage($image, $validated_finding);
    //                         } else {
    //                             Log::info('finding with description inserted on ' . $validated['trafo'] . ' update record', ['checker' => session('user')]);
    //                             $this->findingService->insert($validated_finding);
    //                         }
    //                     } else {
    //                         if (!is_null($image) && $image->isValid()) {

    //                             Log::info('finding trafo record ' . $validated['trafo'] . ' with image updated', ['checker' => session('user')]);
    //                             $validated_finding['image'] = $validated['id'] . '.' . $image->getClientOriginalExtension();
    //                             $this->findingService->updateWithImage($image, $validated_finding);
    //                         } else {
    //                             Log::info('finding trafo record ' . $validated['trafo'] . ' with description updated', ['checker' => session('user')]);
    //                             $this->findingService->update($validated_finding);
    //                         }
    //                     }
    //                 } else {

    //                     if (!is_null($finding)) {
    //                         $this->findingService->deleteImage($finding);
    //                         $finding->delete();
    //                         Log::info('finding was deleted on trafo record ' . $validated['trafo']);
    //                     }
    //                 }

    //                 return redirect()->back()->with('alert', ['message' => 'The trafo record successfully updated.', 'variant' => 'alert-success'])->withInput();
    //             }
    //         } catch (Exception $error) {
    //             return redirect()->back()->withErrors($error->getMessage())->withInput();
    //         }

    //         return redirect()->back()->with('alert', ['message' => 'The trafo record successfully saved.', 'variant' => 'alert-success', 'record_id' => 'trafo/' . $validated_record['id']]);
    //     } else {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }
    // }


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

            $image = $request->file('finding_image');
            $validated_finding = [
                'id' => $validated['id'],
                'area' => explode('-', $validated['funcloc'])[2],
                'description' => $validated['finding_description'],
                'equipment' => $validated['trafo'],
                'funcloc' => $validated['funcloc'],
                'reporter' => Auth::user()->abbreviated_name,
            ];

            if (!empty($validated['finding_description'])) {

                if (!is_null($image) && $image->isValid()) {
                    $validated_finding['image'] = $validated['id'] . '.' . $image->getClientOriginalExtension();
                    $this->findingService->insertWithImage($image, $validated_finding);
                } else {
                    $this->findingService->insert($validated_finding);
                }
            }

            DB::commit();
        } catch (Exception $error) {
            DB::rollback();
            return back()->with('alert', new Alert($error->getMessage(), 'alert-danger'))->withInput();
        }

        return back()->with('alert', new Alert('The trafo record successfully saved.', 'alert-success', 'record-edit/trafo/' .  $validated_record['id']));
    }

    // public function editRecordTrafo(string $uniqid)
    // {
    //     $record = TrafoRecord::query()->find($uniqid);
    //     $finding = Finding::query()->find($uniqid);

    //     if (!is_null($record)) {

    //         return response()->view('maintenance.trafo.checking-form', [
    //             'title' => 'Trafo record edit',
    //             'trafoService' => $this->trafoService,
    //             'record' => $record,
    //             'finding' => $finding,
    //         ]);
    //     } else {
    //         return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The record $uniqid is not found."]);
    //     }
    // }

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
