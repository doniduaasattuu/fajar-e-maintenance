<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Services\MotorService;
use App\Services\UserService;
use App\Traits\Utility;
use Illuminate\Http\JsonResponse;
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

    public function search(Request $request): RedirectResponse | JsonResponse
    {
        $equipment = $request->input('equipment');

        if ($equipment != null && strlen($equipment) === 9) {

            $equipment_code = $this->getEquipmentCode($equipment);

            if (in_array($equipment_code, $this->motorService->motorCodes())) {

                $motor = Motor::query()->find($equipment);

                if (!is_null($motor)) {
                    $equipment_id = $this->getEquipmentId($motor->qr_code_link);

                    return redirect()->action([RecordController::class, 'checkingForm'], [
                        'equipment_id' => $equipment_id
                    ]);
                } else {
                    return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The equipment $equipment was not found."]);
                }
            } else if (in_array($equipment_code, ['ETF']))
                return response()->json([
                    'id' => 'id',
                    'equipment' => $equipment,
                ]);
            else {
                return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The equipment $equipment was not found."]);
            }
        } else {

            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The submitted equipment is invalid."]);
        }
    }
}
