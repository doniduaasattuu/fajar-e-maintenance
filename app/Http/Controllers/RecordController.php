<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\MotorRecord;
use App\Models\User;
use App\Services\FindingService;
use App\Services\MotorRecordService;
use App\Services\MotorService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class RecordController extends Controller
{
    private MotorService $motorService;
    private MotorRecordService $motorRecordService;
    private FindingService $findingService;

    public function __construct(
        MotorService $motorService,
        MotorRecordService $motorRecordService,
        FindingService $findingService,
    ) {
        $this->motorService = $motorService;
        $this->motorRecordService = $motorRecordService;
        $this->findingService = $findingService;
    }

    public function checkingForm(string $equipment_id)
    {
        $equipment_type = preg_replace('/[0-9]/i', '', $equipment_id);

        if ($equipment_type == 'Fajar-MotorList') {

            $unique_id = preg_replace('/[a-zA-Z\-]/i', '', $equipment_id);
            $motor = Motor::query()->with(['MotorDetail'])->where('unique_id', '=', $unique_id)->first();

            if (!is_null($motor)) {

                return response()->view('maintenance.motor.checking-form', [
                    'title' => 'Checking form',
                    'motorService' => $this->motorService,
                    'motor' => $motor,
                    'motorDetail' => $motor->MotorDetail,
                ]);
            } else {
                return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => 'The motor with id ' . $unique_id . ' was not found.']);
            }
        } else if ($equipment_type == 'Fajar-TrafoList') {
            echo 'Trafo';
        } else {
            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => 'The scanned qr code not found.']);
        }
    }

    public function saveRecordMotor(Request $request)
    {
        $request->mergeIfMissing(['id' => uniqid()]);
        $data = $request->all();

        $rules = [
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
            'nik' => ['required', 'digits:8', 'numeric', Rule::in(session('nik')), 'exists:App\Models\User,nik'],
            'finding_description' => ['nullable', 'min:15'],
            'finding_image' => ['nullable', 'prohibited_if:finding_description,null', File::types(['png', 'jpeg', 'jpg'])],
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {

            $validated = $validator->validated();
            $validated_record = $validator->safe()->except(['finding_description', 'finding_image']);

            try {

                $record = MotorRecord::query()->find($validated_record['id']);

                if (is_null($record)) {

                    // SAVE RECORD
                    $this->motorRecordService->save($validated_record);

                    // SAVE FINDING
                    if (!empty($validated['finding_description'])) {

                        $validated_finding = [
                            'area' => explode('-', $validated['funcloc'])[2],
                            'description' => $validated['finding_description'] ?? null,
                            'equipment' => $validated['motor'],
                            'funcloc' => $validated['funcloc'],
                            'reporter' => User::query()->find($validated['nik'])->abbreviated_name,
                        ];

                        if ($request->hasFile('finding_image')) {

                            $image_url = $validated['id'];
                            array_push($validated_finding, ['image' => $image_url]);

                            $image = $request->finding_image;
                            $this->findingService->saveImage($image, $image_url);
                        }

                        $this->findingService->insert($validated_finding);
                    }
                } else {

                    // UPDATE RECORD
                    $this->motorRecordService->update($record, $validated_record);
                    return redirect()->back()->with('alert', ['message' => 'The motor record successfully updated.', 'variant' => 'alert-success'])->withInput();
                }
            } catch (Exception $error) {
                return redirect()->back()->withErrors($error->getMessage())->withInput();
            }

            return redirect()->back()->with('alert', ['message' => 'The motor record successfully saved.', 'variant' => 'alert-success', 'record_id' => $validated_record['id']]);
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function editRecordMotor(string $uniqid)
    {
        $record = MotorRecord::query()->find($uniqid);

        if (!is_null($record)) {

            return response()->view('maintenance.motor.checking-form', [
                'title' => 'Motor record edit',
                'motorService' => $this->motorService,
                'record' => $record,
            ]);
        } else {
            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The record $uniqid is not found."]);
        }
    }
}
