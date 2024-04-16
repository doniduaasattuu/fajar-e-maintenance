<?php

namespace Database\Seeders;

use App\Models\Trafo;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrafoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trafo01 = new Trafo();
        $trafo01->id = 'ETF000006';
        $trafo01->status = 'Installed';
        $trafo01->funcloc = 'FP-01-IN1-TRF';
        $trafo01->sort_field = 'TR INCHENERATOR#2';
        $trafo01->description = 'TR INCHENERATOR#2';
        $trafo01->material_number = null;
        $trafo01->unique_id = '8';
        $trafo01->qr_code_link = 'id=Fajar-TrafoList8';
        $trafo01->created_at = Carbon::now();
        $trafo01->updated_at = null;
        $trafo01->save();

        $trafo02 = new Trafo();
        $trafo02->id = 'ETF000026';
        $trafo02->status = 'Installed';
        $trafo02->funcloc = 'FP-01-GT2-TRF-PWP2';
        $trafo02->sort_field = 'TR AUX GTG #1 lama';
        $trafo02->description = 'TR AUX GTG #1 lama';
        $trafo02->material_number = null;
        $trafo02->unique_id = '4';
        $trafo02->qr_code_link = 'id=Fajar-TrafoList4';
        $trafo02->created_at = Carbon::now();
        $trafo02->updated_at = null;
        $trafo02->save();

        $trafo03 = new Trafo();
        $trafo03->id = 'ETF000027';
        $trafo03->status = 'Installed';
        $trafo03->funcloc = 'FP-01-ENC-TRF-PLN1';
        $trafo03->sort_field = 'TR GTG #1';
        $trafo03->description = 'TR GTG #1';
        $trafo03->material_number = null;
        $trafo03->unique_id = '2';
        $trafo03->qr_code_link = 'id=Fajar-TrafoList2';
        $trafo03->created_at = Carbon::now();
        $trafo03->updated_at = null;
        $trafo03->save();

        $trafo04 = new Trafo();
        $trafo04->id = 'ETF000032';
        $trafo04->status = 'Installed';
        $trafo04->funcloc = 'FP-01-IN1-TRF';
        $trafo04->sort_field = 'TR WWT';
        $trafo04->description = 'TR WWT';
        $trafo04->material_number = null;
        $trafo04->unique_id = '9';
        $trafo04->qr_code_link = 'id=Fajar-TrafoList9';
        $trafo04->created_at = Carbon::now();
        $trafo04->updated_at = null;
        $trafo04->save();

        $trafo05 = new Trafo();
        $trafo05->id = 'ETF000059';
        $trafo05->status = 'Installed';
        $trafo05->funcloc = 'FP-01-GT1';
        $trafo05->sort_field = 'TR AUX GTG #2';
        $trafo05->description = 'TR AUX GTG #2';
        $trafo05->material_number = null;
        $trafo05->unique_id = '5';
        $trafo05->qr_code_link = 'id=Fajar-TrafoList5';
        $trafo05->created_at = Carbon::now();
        $trafo05->updated_at = null;
        $trafo05->save();

        $trafo06 = new Trafo();
        $trafo06->id = 'ETF000060';
        $trafo06->status = 'Installed';
        $trafo06->funcloc = 'FP-01-GT1-TRF-PWP1';
        $trafo06->sort_field = 'TR GTG #2';
        $trafo06->description = 'TR GTG #2';
        $trafo06->material_number = null;
        $trafo06->unique_id = '3';
        $trafo06->qr_code_link = 'id=Fajar-TrafoList3';
        $trafo06->created_at = Carbon::now();
        $trafo06->updated_at = null;
        $trafo06->save();

        $trafo07 = new Trafo();
        $trafo07->id = 'ETF000085';
        $trafo07->status = 'Installed';
        $trafo07->funcloc = 'FP-01-IN1';
        $trafo07->sort_field = 'TRAFO PLN';
        $trafo07->description = 'TRAFO;STEP DOWN;150/20kV;UNINDO 50 KVA;';
        $trafo07->material_number = null;
        $trafo07->unique_id = '1';
        $trafo07->qr_code_link = 'id=Fajar-TrafoList1';
        $trafo07->created_at = Carbon::now();
        $trafo07->updated_at = null;
        $trafo07->save();

        $trafo08 = new Trafo();
        $trafo08->id = 'ETF000091';
        $trafo08->status = 'Installed';
        $trafo08->funcloc = 'FP-01-IN1';
        $trafo08->sort_field = 'TRAFO ESP BOILER 3 NO.1';
        $trafo08->description = 'TRAFO ESP BOILER 3 NO.1';
        $trafo08->material_number = null;
        $trafo08->unique_id = '10';
        $trafo08->qr_code_link = 'id=Fajar-TrafoList10';
        $trafo08->created_at = Carbon::now();
        $trafo08->updated_at = null;
        $trafo08->save();

        $trafo09 = new Trafo();
        $trafo09->id = 'ETF000092';
        $trafo09->status = 'Installed';
        $trafo09->funcloc = 'FP-01-CFB-CSD-ESPR';
        $trafo09->sort_field = 'TRAFO ESP BOILER 3 NO.2';
        $trafo09->description = null;
        $trafo09->material_number = null;
        $trafo09->unique_id = '11';
        $trafo09->qr_code_link = 'id=Fajar-TrafoList11';
        $trafo09->created_at = Carbon::now();
        $trafo09->updated_at = null;
        $trafo09->save();

        $trafo10 = new Trafo();
        $trafo10->id = 'ETF000093';
        $trafo10->status = 'Installed';
        $trafo10->funcloc = 'FP-01-CFB-CSD-ESPR';
        $trafo10->sort_field = 'TRAFO ESP BOILER 3 NO.3';
        $trafo10->description = null;
        $trafo10->material_number = null;
        $trafo10->unique_id = '12';
        $trafo10->qr_code_link = 'id=Fajar-TrafoList12';
        $trafo10->created_at = Carbon::now();
        $trafo10->updated_at = null;
        $trafo10->save();

        $trafo11 = new Trafo();
        $trafo11->id = 'ETF000105';
        $trafo11->status = 'Installed';
        $trafo11->funcloc = 'FP-01-CFB-CSD-ESPR';
        $trafo11->sort_field = 'TRAFO ESP BOILER 5 NO.1';
        $trafo11->description = null;
        $trafo11->material_number = null;
        $trafo11->unique_id = '13';
        $trafo11->qr_code_link = 'id=Fajar-TrafoList13';
        $trafo11->created_at = Carbon::now();
        $trafo11->updated_at = null;
        $trafo11->save();

        $trafo12 = new Trafo();
        $trafo12->id = 'ETF000106';
        $trafo12->status = 'Installed';
        $trafo12->funcloc = 'FP-01-GT3-BO5-CNSY-ESPR';
        $trafo12->sort_field = 'TRAFO ESP BOILER 5 NO.2';
        $trafo12->description = null;
        $trafo12->material_number = null;
        $trafo12->unique_id = '14';
        $trafo12->qr_code_link = 'id=Fajar-TrafoList14';
        $trafo12->created_at = Carbon::now();
        $trafo12->updated_at = null;
        $trafo12->save();

        $trafo13 = new Trafo();
        $trafo13->id = 'ETF000107';
        $trafo13->status = 'Installed';
        $trafo13->funcloc = 'FP-01-GT3-BO5-CNSY-ESPR';
        $trafo13->sort_field = 'TRAFO ESP BOILER 5 NO.3';
        $trafo13->description = null;
        $trafo13->material_number = null;
        $trafo13->unique_id = '15';
        $trafo13->qr_code_link = 'id=Fajar-TrafoList15';
        $trafo13->created_at = Carbon::now();
        $trafo13->updated_at = null;
        $trafo13->save();

        $trafo14 = new Trafo();
        $trafo14->id = 'ETF000108';
        $trafo14->status = 'Installed';
        $trafo14->funcloc = 'FP-01-GT3-BO5-CNSY-ESPR';
        $trafo14->sort_field = 'TRAFO ESP BOILER 6 NO.1';
        $trafo14->description = null;
        $trafo14->material_number = null;
        $trafo14->unique_id = '16';
        $trafo14->qr_code_link = 'id=Fajar-TrafoList16';
        $trafo14->created_at = Carbon::now();
        $trafo14->updated_at = null;
        $trafo14->save();

        $trafo15 = new Trafo();
        $trafo15->id = 'ETF000109';
        $trafo15->status = 'Installed';
        $trafo15->funcloc = 'FP-01-GT3-BO6-CNSY-ESPR';
        $trafo15->sort_field = 'TRAFO ESP BOILER 6 NO.2';
        $trafo15->description = null;
        $trafo15->material_number = null;
        $trafo15->unique_id = '17';
        $trafo15->qr_code_link = 'id=Fajar-TrafoList17';
        $trafo15->created_at = Carbon::now();
        $trafo15->updated_at = null;
        $trafo15->save();

        $trafo16 = new Trafo();
        $trafo16->id = 'ETF000110';
        $trafo16->status = 'Installed';
        $trafo16->funcloc = 'FP-01-GT3-BO6-CNSY-ESPR';
        $trafo16->sort_field = 'TRAFO ESP BOILER 6 NO.3';
        $trafo16->description = null;
        $trafo16->material_number = null;
        $trafo16->unique_id = '18';
        $trafo16->qr_code_link = 'id=Fajar-TrafoList18';
        $trafo16->created_at = Carbon::now();
        $trafo16->updated_at = null;
        $trafo16->save();

        $trafo17 = new Trafo();
        $trafo17->id = 'ETF000111';
        $trafo17->status = 'Installed';
        $trafo17->funcloc = 'FP-01-GT3-TRB-TRF1';
        $trafo17->sort_field = 'TR START/STANBY';
        $trafo17->description = null;
        $trafo17->material_number = null;
        $trafo17->unique_id = '20';
        $trafo17->qr_code_link = 'id=Fajar-TrafoList20';
        $trafo17->created_at = Carbon::now();
        $trafo17->updated_at = null;
        $trafo17->save();

        $trafo18 = new Trafo();
        $trafo18->id = 'ETF000112';
        $trafo18->status = 'Installed';
        $trafo18->funcloc = 'FP-01-GT3-TRB-TRF1';
        $trafo18->sort_field = 'TR AUXILIARY';
        $trafo18->description = null;
        $trafo18->material_number = null;
        $trafo18->unique_id = '21';
        $trafo18->qr_code_link = 'id=Fajar-TrafoList21';
        $trafo18->created_at = Carbon::now();
        $trafo18->updated_at = null;
        $trafo18->save();

        $trafo19 = new Trafo();
        $trafo19->id = 'ETF000113';
        $trafo19->status = 'Installed';
        $trafo19->funcloc = 'FP-01-GT3-BO6-CNSY-ESPR';
        $trafo19->sort_field = 'TR GT3 STEP-UP ';
        $trafo19->description = null;
        $trafo19->material_number = null;
        $trafo19->unique_id = '19';
        $trafo19->qr_code_link = 'id=Fajar-TrafoList19';
        $trafo19->created_at = Carbon::now();
        $trafo19->updated_at = null;
        $trafo19->save();

        $trafo20 = new Trafo();
        $trafo20->id = 'ETF000114';
        $trafo20->status = 'Installed';
        $trafo20->funcloc = 'FP-01-GT3-TRB-TRF1';
        $trafo20->sort_field = 'TR AUX MV-LV #1';
        $trafo20->description = null;
        $trafo20->material_number = null;
        $trafo20->unique_id = '22';
        $trafo20->qr_code_link = 'id=Fajar-TrafoList22';
        $trafo20->created_at = Carbon::now();
        $trafo20->updated_at = null;
        $trafo20->save();

        $trafo21 = new Trafo();
        $trafo21->id = 'ETF000115';
        $trafo21->status = 'Installed';
        $trafo21->funcloc = 'FP-01-GT3-TRB-TRF1';
        $trafo21->sort_field = 'TR AUX MV-LV #2';
        $trafo21->description = null;
        $trafo21->material_number = null;
        $trafo21->unique_id = '23';
        $trafo21->qr_code_link = 'id=Fajar-TrafoList23';
        $trafo21->created_at = Carbon::now();
        $trafo21->updated_at = null;
        $trafo21->save();

        $trafo22 = new Trafo();
        $trafo22->id = 'ETF000120';
        $trafo22->status = 'Installed';
        $trafo22->funcloc = 'FP-01-GT2-TRF-UTY2';
        $trafo22->sort_field = 'TR AUX GTG #1 Baru';
        $trafo22->description = 'TR AUX GTG #1 Baru';
        $trafo22->material_number = null;
        $trafo22->unique_id = '6';
        $trafo22->qr_code_link = 'id=Fajar-TrafoList6';
        $trafo22->created_at = Carbon::now();
        $trafo22->updated_at = null;
        $trafo22->save();

        $trafo23 = new Trafo();
        $trafo23->id = 'ETF000123';
        $trafo23->status = 'Installed';
        $trafo23->funcloc = 'FP-01-GT1-TRF-UTY1';
        $trafo23->sort_field = 'TR INCHENERATOR#1';
        $trafo23->description = 'TR INCHENERATOR#1';
        $trafo23->material_number = null;
        $trafo23->unique_id = '7';
        $trafo23->qr_code_link = 'id=Fajar-TrafoList7';
        $trafo23->created_at = Carbon::now();
        $trafo23->updated_at = null;
        $trafo23->save();

        $trafo24 = new Trafo();
        $trafo24->id = 'ETF000124';
        $trafo24->status = 'Installed';
        $trafo24->funcloc = 'FP-01-GT3-TRB-TRF1';
        $trafo24->sort_field = 'INCI # 1 (New)';
        $trafo24->description = null;
        $trafo24->material_number = null;
        $trafo24->unique_id = '24';
        $trafo24->qr_code_link = 'id=Fajar-TrafoList24';
        $trafo24->created_at = Carbon::now();
        $trafo24->updated_at = null;
        $trafo24->save();

        $trafo25 = new Trafo();
        $trafo25->id = 'ETF000125';
        $trafo25->status = 'Installed';
        $trafo25->funcloc = 'FP-01-IN1';
        $trafo25->sort_field = 'WT-1';
        $trafo25->description = null;
        $trafo25->material_number = null;
        $trafo25->unique_id = '25';
        $trafo25->qr_code_link = 'id=Fajar-TrafoList25';
        $trafo25->created_at = Carbon::now();
        $trafo25->updated_at = null;
        $trafo25->save();

        $trafo26 = new Trafo();
        $trafo26->id = 'ETF000126';
        $trafo26->status = 'Installed';
        $trafo26->funcloc = 'FP-01-IN1';
        $trafo26->sort_field = 'TRAFO MV CELL';
        $trafo26->description = null;
        $trafo26->material_number = null;
        $trafo26->unique_id = '26';
        $trafo26->qr_code_link = 'id=Fajar-TrafoList26';
        $trafo26->created_at = Carbon::now();
        $trafo26->updated_at = null;
        $trafo26->save();

        $trafo27 = new Trafo();
        $trafo27->id = 'ETF001234';
        $trafo27->status = 'Available';
        $trafo27->funcloc = null;
        $trafo27->sort_field = null;
        $trafo27->description = null;
        $trafo27->material_number = null;
        $trafo27->unique_id = '1234';
        $trafo27->qr_code_link = 'id=Fajar-TrafoList1234';
        $trafo27->created_at = Carbon::now();
        $trafo27->updated_at = null;
        $trafo27->save();

        $trafo28 = new Trafo();
        $trafo28->id = 'ETF004321';
        $trafo28->status = 'Repaired';
        $trafo28->funcloc = null;
        $trafo28->sort_field = null;
        $trafo28->description = null;
        $trafo28->material_number = null;
        $trafo28->unique_id = '4321';
        $trafo28->qr_code_link = 'id=Fajar-TrafoList4321';
        $trafo28->created_at = Carbon::now();
        $trafo28->updated_at = null;
        $trafo28->save();
    }
}
