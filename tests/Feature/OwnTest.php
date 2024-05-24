<?php

namespace Tests\Feature;

use App\Models\MotorRecord;
use Carbon\Carbon;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorDetailsSeeder;
use Database\Seeders\MotorRecordSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OwnTest extends TestCase
{

    // public function testGetSlotUniqueId()
    // {
    //     $unique = [1, 5, 8, 9, 11, 13, 14, 15, 16];
    //     $normal = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];

    //     function getSlot(array $unique): array
    //     {
    //         $slot = [];
    //         for ($i = 0; $i < count($unique); $i++) {

    //             if (array_key_exists($i + 1, $unique)) {
    //                 if ($unique[$i] + 1 != $unique[$i + 1]) {
    //                     for ($j = $unique[$i] + 1; $j < $unique[$i + 1]; $j++) {
    //                         array_push($slot, $j);
    //                     }
    //                 }
    //             }
    //         }

    //         return $slot;
    //     }

    //     self::assertCount(7, getSlot($unique));
    //     self::assertEquals(2, getSlot($unique)[0]);
    //     self::assertCount(0, getSlot($normal));
    //     self::assertEmpty(getSlot($normal));
    // }

    // public function testGetFirstUniqueId()
    // {
    //     $unique = [1, 5, 8, 9, 11, 13, 14, 15, 16];
    //     $normal = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];

    //     function getFirstSlot(array $unique)
    //     {
    //         for ($i = 0; $i < count($unique); $i++) {
    //             if (array_key_exists($i + 1, $unique)) {
    //                 if ($unique[$i] + 1 != $unique[$i + 1]) {
    //                     return $unique[$i] + 1;
    //                 }
    //             } else {
    //                 return $unique[$i] + 1;
    //             }
    //         }
    //     }

    //     self::assertEquals(2, getFirstSlot($unique));
    //     self::assertEquals(17, getFirstSlot($normal));
    // }

    // public function testDate()
    // {
    //     $date = Carbon::now()->addDays(-1)->format('d M Y');
    //     self::assertTrue(true);
    // }

    // public function testCheckTableRecord()
    // {
    //     $records = DB::table('motor_records')->select()->whereBetween('created_at', [Carbon::now()->addDays(-1), Carbon::now()])->get();
    //     self::assertEmpty($records);
    //     self::assertCount(0, $records);
    // }

    // public function testCheckTableRecordNotEmpty()
    // {
    //     $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

    //     $record1 = new MotorRecord();
    //     $record1->id = uniqid();
    //     $record1->funcloc = "FP-01-PM3-REL-PPRL-PRAR";
    //     $record1->motor = "MGM000481";
    //     $record1->sort_field = "PM3.REEL.PRAR/GM";
    //     $record1->motor_status = array(0 => "Running", 1 => "Not Running")[rand(0, 1)];
    //     $record1->cleanliness = "Clean";
    //     $record1->nipple_grease = "Available";
    //     $record1->number_of_greasing = rand(3, 8) * 10;
    //     $record1->temperature_de = rand(3500, 10000) / 100;
    //     $record1->temperature_body = rand(3500, 10000) / 100;
    //     $record1->temperature_nde = rand(3500, 10000) / 100;
    //     $record1->vibration_de_vertical_value = rand(45, 112) / 100;
    //     $record1->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
    //     $record1->vibration_de_horizontal_value = rand(45, 112) / 100;
    //     $record1->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
    //     $record1->vibration_de_axial_value = rand(45, 112) / 100;
    //     $record1->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
    //     $record1->vibration_de_frame_value = rand(45, 112) / 100;
    //     $record1->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
    //     $record1->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
    //     $record1->vibration_nde_vertical_value = rand(45, 112) / 100;
    //     $record1->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
    //     $record1->vibration_nde_horizontal_value = rand(45, 112) / 100;
    //     $record1->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
    //     $record1->vibration_nde_frame_value = rand(45, 112) / 100;
    //     $record1->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
    //     $record1->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
    //     $record1->nik = '55000154';
    //     $record1->created_at = Carbon::now()->addDays(-1);
    //     $record1->save();

    //     $records = DB::table('motor_records')->select()->whereBetween('created_at', [Carbon::now()->addDays(-1), Carbon::now()])->get();
    //     self::assertNotEmpty($records);
    //     self::assertCount(1, $records);
    // }
}
