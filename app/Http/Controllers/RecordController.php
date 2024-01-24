<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Services\MotorService;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    private MotorService $motorService;

    public function __construct(MotorService $motorService)
    {
        $this->motorService = $motorService;
    }

    public function checkingForm(string $equipment_id)
    {
        $equipment_type = preg_replace('/[0-9]/i', '', $equipment_id);

        if ($equipment_type == 'Fajar-MotorList') {

            $unique_id = preg_replace('/[a-zA-Z\-]/i', '', $equipment_id);
            $motor = Motor::query()->with(['MotorDetail'])->where('unique_id', '=', $unique_id)->first();

            if (!is_null($motor)) {

                return $this->motorForm($motor);
            } else {
                return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => 'The motor with id ' . $unique_id . ' was not found.']);
            }
        } else if ($equipment_type == 'Fajar-TrafoList') {
            echo 'Trafo';
        } else {
            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => 'The scanned qr code not found.']);
        }
    }

    public function motorForm(Motor $motor)
    {
        return response()->view('maintenance.motor.checking-form', [
            'title' => 'Checking form',
            'motorService' => $this->motorService,
            'motor' => $motor,
        ]);
    }
}
