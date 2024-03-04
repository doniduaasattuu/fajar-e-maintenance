<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\MotorRecord;
use App\Models\Trafo;
use App\Models\User;
use App\Services\MotorService;
use App\Services\TrafoService;
use App\Services\UserService;
use App\Traits\Utility;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    use Utility;
    private MotorService $motorService;
    private TrafoService $trafoService;

    public function __construct(MotorService $motorService, TrafoService $trafoService)
    {
        $this->motorService = $motorService;
        $this->trafoService = $trafoService;
    }

    public function home()
    {
        return response()->view('maintenance.home', [
            'title' => 'Fajar E-Maintenance',
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
        $current_user = User::query()->find(session('nik'));

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

            if (!is_null($motor) && $current_user->isDbAdmin()) {
                return redirect()->action([MotorController::class, 'motorEdit'], ['id' => $motor->id]);
            } else if (!is_null($motor)) {
                return redirect()->action([MotorController::class, 'motorDetails'], ['id' => $motor->id]);
            } else {
                return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The submitted unique id $unique_id was not found."]);
            }
        } else if ($search != null && str_starts_with(strtolower($search), 'trafo')) {

            $unique_id = preg_replace('/[^0-9]/i', '', $search);
            $trafo = Trafo::query()->where('unique_id', '=', $unique_id)->first();

            if (!is_null($trafo) && $current_user->isDbAdmin()) {
                return redirect()->action([TrafoController::class, 'trafoEdit'], ['id' => $trafo->id]);
            } else if (!is_null($trafo)) {
                return redirect()->action([TrafoController::class, 'trafoDetails'], ['id' => $trafo->id]);
            } else {
                return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The submitted unique id $unique_id was not found."]);
            }
        } else {
            return redirect()->back()->with('message', ['header' => '[404] Not found.', 'message' => "The submitted value is invalid."]);
        }
    }

    public function populatingForms()
    {

        return response()->view('maintenance.populating-forms', [
            'title' => 'Populating forms',
        ]);
    }

    public function populating(Request $request)
    {
        $equipments = $request->input("equipments");
        $equipments = explode(",", $equipments);

        $result = [];
        foreach ($equipments as $equipment) {
            if (in_array($this->getEquipmentCode($equipment), $this->motorService->motorCodes())) {
                $motor = Motor::query()->find($equipment);
                if ($motor) {
                    array_push($result, "/checking-form/Fajar-MotorList" . $motor->unique_id);
                }
            } else {
                $trafo = Trafo::query()->find($equipment);
                if ($trafo) {
                    array_push($result, "/checking-form/Fajar-TrafoList" . $trafo->unique_id);
                }
            };
        }

        return response()->view('maintenance.populating-forms', [
            'title' => 'Populating forms',
            'links' => $result,
        ]);
    }
}
