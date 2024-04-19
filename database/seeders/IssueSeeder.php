<?php

namespace Database\Seeders;

use App\Models\Issue;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $target_date = Carbon::now()->addMonths(1)->toDateString();

        Issue::create([
            [
                'id' => uniqid(),
                'issued_date' => Carbon::now()->toDateString(),
                'target_date' => $target_date,
                'remaining_days' => $target_date,
                'section' => 'ELC',
                'area' => 'SP3',
                'description' => 'Drum thickener SP32 not rotating DT 98 Minute',
                'corrective_action' => 'Checking inverter (inverter not trip, Load motor SP32 high = 30A). Info to production for cleaning drum thickener and running well',
                'root_cause' => 'Load motor SP32 high and drum cannot rotating',
                'preventive_action' => 'Cleaning drum by production',
                'status' => 'NOT',
                'remark' => 'DT 98 MINUTES FROM PM3',
                'department' => 'EI2',
                'created_by' => 'Nopriadi Saputra',
                'updated_by' => 'Nopriadi Saputra',
            ],
            [
                'id' => uniqid(),
                'issued_date' => Carbon::create('2024-04-05')->toDateString(),
                'target_date' => Carbon::create('2024-04-05')->toDateString(),
                'remaining_days' => Carbon::create('2024-04-05')->toDateString(),
                'section' => 'ELC',
                'area' => 'PM3',
                'description' => 'Communication SCADA drive PM3 problem',
                'corrective_action' => 'Replacing MOXA (switch communication)',
                'root_cause' => 'Communication from PLC problem',
                'preventive_action' => null,
                'status' => 'NOT',
                'remark' => null,
                'department' => 'EI2',
                'created_by' => 'Nopriadi Saputra',
                'updated_by' => 'Nopriadi Saputra',
            ],
            [
                'id' => uniqid(),
                'issued_date' => Carbon::create('2024-04-06')->toDateString(),
                'target_date' => Carbon::create('2024-04-06')->toDateString(),
                'remaining_days' => Carbon::create('2024-04-06')->toDateString(),
                'section' => 'INS',
                'area' => 'PM7',
                'description' => 'DCS AC172 Bus 3 Station 2-5 Error, "Cable B Error"',
                'corrective_action' => 'Replace OZD Hirashman Network B',
                'root_cause' => 'OZD Broken',
                'preventive_action' => 'Periodically health check',
                'status' => 'DONE',
                'remark' => null,
                'department' => 'EI2',
                'created_by' => 'Yopi Sofyan',
                'updated_by' => 'Yopi Sofyan',
            ],
            [
                'id' => uniqid(),
                'issued_date' => Carbon::create('2024-04-07')->toDateString(),
                'target_date' => Carbon::create('2024-04-07')->toDateString(),
                'remaining_days' => Carbon::create('2024-04-07')->toDateString(),
                'section' => 'INS',
                'area' => 'PM7',
                'description' => 'Computer Scada AB Chemical 7 Hank',
                'corrective_action' => 'take out and reconnect ethernet cable OK',
                'root_cause' => 'communication error',
                'preventive_action' => null,
                'status' => 'DONE',
                'remark' => null,
                'department' => 'EI2',
                'created_by' => 'Yopi Sofyan',
                'updated_by' => 'Yopi Sofyan',
            ],
            [
                'id' => uniqid(),
                'issued_date' => Carbon::create('2024-04-07')->toDateString(),
                'target_date' => Carbon::create('2024-04-07')->toDateString(),
                'remaining_days' => Carbon::create('2024-04-07')->toDateString(),
                'section' => 'INS',
                'area' => 'PM7',
                'description' => 'PSU DO Remote IO PM07-CCC-005 Broken',
                'corrective_action' => 'Replace PSU',
                'root_cause' => 'PSU Broken',
                'preventive_action' => null,
                'status' => 'DONE',
                'remark' => null,
                'department' => 'EI2',
                'created_by' => 'Yopi Sofyan',
                'updated_by' => 'Yopi Sofyan',
            ],
            [
                'id' => uniqid(),
                'issued_date' => Carbon::create('2024-04-07')->toDateString(),
                'target_date' => Carbon::create('2024-04-07')->toDateString(),
                'remaining_days' => Carbon::create('2024-04-07')->toDateString(),
                'section' => 'ELC',
                'area' => 'PM3',
                'description' => 'Submersible pump warehouse trip',
                'corrective_action' => 'Repair impeller pump by mecanical',
                'root_cause' => 'Impeller of submersible pump is broken',
                'preventive_action' => null,
                'status' => 'DONE',
                'remark' => null,
                'department' => 'EI2',
                'created_by' => 'Nopriadi Saputra',
                'updated_by' => 'Nopriadi Saputra',
            ],
            [
                'id' => uniqid(),
                'issued_date' => Carbon::create('2024-04-08')->toDateString(),
                'target_date' => Carbon::create('2024-04-08')->toDateString(),
                'remaining_days' => Carbon::create('2024-04-08')->toDateString(),
                'section' => 'ELC',
                'area' => 'PM7',
                'description' => 'Osc shower P1B tripped',
                'corrective_action' => 'Repair connection power cable and control at motor',
                'root_cause' => 'Cable control at motor loose connection',
                'preventive_action' => 'Give silicon at jointing motor and cable for protecting motor from water splash',
                'status' => 'DONE',
                'remark' => null,
                'department' => 'EI2',
                'created_by' => 'Nopriadi Saputra',
                'updated_by' => 'Nopriadi Saputra',
            ],
            [
                'id' => uniqid(),
                'issued_date' => Carbon::create('2024-04-09')->toDateString(),
                'target_date' => Carbon::create('2024-04-09')->toDateString(),
                'remaining_days' => Carbon::create('2024-04-09')->toDateString(),
                'section' => 'ELC',
                'area' => 'SP7',
                'description' => 'Finding crimping module P-2P23 high temperature (153⁰C)',
                'corrective_action' => 'Checking module and cleaning crimping module',
                'root_cause' => 'Repair & cleaning crimping',
                'preventive_action' => null,
                'status' => 'DONE',
                'remark' => null,
                'department' => 'EI2',
                'created_by' => 'Nopriadi Saputra',
                'updated_by' => 'Nopriadi Saputra',
            ],
            [
                'id' => uniqid(),
                'issued_date' => Carbon::create('2024-04-11')->toDateString(),
                'target_date' => Carbon::create('2024-04-11')->toDateString(),
                'remaining_days' => Carbon::create('2024-04-11')->toDateString(),
                'section' => 'ELC',
                'area' => 'SP7',
                'description' => 'AG11 trip EOCR (motor burn)',
                'corrective_action' => 'Replacing motor',
                'root_cause' => 'Winding quality',
                'preventive_action' => null,
                'status' => 'DONE',
                'remark' => null,
                'department' => 'EI2',
                'created_by' => 'Nopriadi Saputra',
                'updated_by' => 'Nopriadi Saputra',
            ],
        ]);

        // $issue = new Issue();
        // $issue->id = uniqid();
        // $issue->issued_date = Carbon::now()->toDateString();
        // $issue->target_date = $target_date;
        // $issue->remaining_days = $target_date;
        // $issue->section = 'ELC';
        // $issue->area = 'SP3';
        // $issue->description = 'Drum thickener SP32 not rotating DT 98 Minute';
        // $issue->corrective_action = 'Checking inverter (inverter not trip, Load motor SP32 high = 30A). Info to production for cleaning drum thickener and running well';
        // $issue->root_cause = 'Load motor SP32 high and drum cannot rotating';
        // $issue->preventive_action = 'Cleaning drum by production';
        // $issue->status = 'DONE';
        // $issue->remark = 'DT 98 MINUTES FROM PM3';
        // $issue->department = 'EI2';
        // $issue->created_by = 'Nopriadi Saputra';
        // $issue->updated_by = 'Nopriadi Saputra';
        // $issue->save();
    }
}
