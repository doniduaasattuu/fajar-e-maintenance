<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\MotorRecord;
use App\Models\Trafo;
use App\Services\MotorService;
use App\Services\UserService;
use App\Traits\Utility;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    use Utility;
    private UserService $userService;
    private MotorService $motorService;

    public function __construct(UserService $userService, MotorService $motorService)
    {
        $this->userService = $userService;
        $this->motorService = $motorService;
    }

    public function home()
    {
        return response()->view('maintenance.home', [
            'title' => 'Fajar E-Maintenance',
            'userService' => $this->userService,
        ]);
    }

    public function scanner()
    {
        return response()->view('maintenance.scanner', [
            'title' => 'Scanner'
        ]);
    }

    public function checkingForm()
    {
        return response()->view('maintenance.motor.checking-form', [
            'title' => 'Checking form',
            'motorService' => $this->motorService,
        ]);
    }

    public function search(Request $request): RedirectResponse
    {
        $search = $request->input('search_equipment');

        if ($search != null && strlen($search) === 9 && !str_starts_with(strtolower($search), 'motor')) {

            $equipment_code = $this->getEquipmentCode($search);

            if (in_array($equipment_code, $this->motorService->motorCodes())) {

                $motor = Motor::query()->find($search);

                if (!is_null($motor)) {
                    $equipment_id = $this->getEquipmentId($motor->qr_code_link);

                    return redirect()->action([RecordController::class, 'checkingForm'], [
                        'equipment_id' => $equipment_id
                    ]);
                } else {
                    return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The equipment $search was not found."]);
                }
            } else if (in_array($equipment_code, ['ETF'])) {

                $trafo = Trafo::query()->find($search);

                if (!is_null($trafo)) {
                    $equipment_id = $this->getEquipmentId($trafo->qr_code_link);

                    return redirect()->action([RecordController::class, 'checkingForm'], [
                        'equipment_id' => $equipment_id
                    ]);
                } else {
                    return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The equipment $search was not found."]);
                }
            } else {
                return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The equipment $search was not found."]);
            }
        } else if ($search != null && str_starts_with(strtolower($search), 'motor')) {

            $unique_id = preg_replace('/[^0-9]/i', '', $search);
            $motor = Motor::query()->where('unique_id', '=', $unique_id)->first();

            if (!is_null($motor)) {
                return redirect()->action([MotorController::class, 'motorEdit'], ['id' => $motor->id]);
            } else {
                return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The submitted unique id $unique_id was not found."]);
            }
        } else if ($search != null && str_starts_with(strtolower($search), 'trafo')) {

            $unique_id = preg_replace('/[^0-9]/i', '', $search);
            $trafo = Trafo::query()->where('unique_id', '=', $unique_id)->first();

            if (!is_null($trafo)) {
                return redirect()->action([TrafoController::class, 'trafoEdit'], ['id' => $trafo->id]);
            } else {
                return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The submitted unique id $unique_id was not found."]);
            }
        } else {
            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The submitted value is invalid."]);
        }
    }
}
