<?php

namespace App\Http\Controllers;

use App\Data\Modal;
use App\Models\Motor;
use App\Models\Trafo;
use App\Services\MotorService;
use App\Services\TrafoService;
use App\Traits\Utility;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use Utility;
    private MotorService $motorService;

    public function __construct(
        MotorService $motorService,
    ) {
        $this->motorService = $motorService;
    }

    public function home()
    {
        return view('maintenance.home');
    }

    public function scanner()
    {
        return view('maintenance.scanner', [
            'title' => 'Scanner'
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
                    return back()->with('modal', new Modal('[404] Not found', "The equipment $search was not found."));
                }
            } else if (in_array($equipment_code, ['ETF'])) {

                $trafo = Trafo::query()->find($search);

                if (!is_null($trafo)) {
                    $equipment_id = $this->getEquipmentId($trafo->qr_code_link);

                    return redirect()->action([RecordController::class, 'checkingForm'], [
                        'equipment_id' => $equipment_id
                    ]);
                } else {
                    return back()->with('modal', new Modal('[404] Not found', "The equipment $search was not found."));
                }
            } else {
                return back()->with('modal', new Modal('[404] Not found', "The equipment $search was not found."));
            }
        } else if ($search != null && str_starts_with(strtolower($search), 'motor')) {

            $unique_id = preg_replace('/[^0-9]/i', '', $search);
            $motor = Motor::query()->where('unique_id', '=', $unique_id)->first();

            if (!is_null($motor)) {
                $equipment_id = explode('=', $motor->qr_code_link)[1];
                return redirect()->action([RecordController::class, 'checkingForm'], ['equipment_id' => $equipment_id]);
            } else {
                return back()->with('modal', new Modal('[404] Not found', "The motor with unique id $unique_id was not found."));
            }
        } else if ($search != null && str_starts_with(strtolower($search), 'trafo')) {

            $unique_id = preg_replace('/[^0-9]/i', '', $search);
            $trafo = Trafo::query()->where('unique_id', '=', $unique_id)->first();

            if (!is_null($trafo)) {
                $equipment_id = explode('=', $trafo->qr_code_link)[1];

                return redirect()->action([RecordController::class, 'checkingForm'], ['equipment_id' => $equipment_id]);
            } else {
                return back()->with('modal', new Modal('[404] Not found', "The trafo with unique id $unique_id was not found."));
            }
        } else {
            return back()->with('modal', new Modal('[404] Not found', "The submitted value is invalid."));
        }
    }

    // public function populatingForms()
    // {

    //     return response()->view('maintenance.populating-forms', [
    //         'title' => 'Populating forms',
    //     ]);
    // }

    // public function populating(Request $request)
    // {
    //     $equipments = $request->input("equipments");
    //     $equipments = explode(",", $equipments);

    //     $result = [];
    //     foreach ($equipments as $equipment) {
    //         if (in_array($this->getEquipmentCode($equipment), $this->motorService->motorCodes())) {
    //             $motor = Motor::query()->find($equipment);
    //             if ($motor) {
    //                 array_push($result, "/checking-form/Fajar-MotorList" . $motor->unique_id);
    //             }
    //         } else {
    //             $trafo = Trafo::query()->find($equipment);
    //             if ($trafo) {
    //                 array_push($result, "/checking-form/Fajar-TrafoList" . $trafo->unique_id);
    //             }
    //         };
    //     }

    //     return response()->view('maintenance.populating-forms', [
    //         'title' => 'Populating forms',
    //         'links' => $result,
    //     ]);
    // }
}
