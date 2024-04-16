<?php

namespace Database\Seeders;

use App\Models\Funcloc;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FunclocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $funcloc01 = new Funcloc();
        $funcloc01->id = 'FP-01-BO3-CAS-COM2';
        $funcloc01->sort_field = 'BO3.CAS.COM2/M';
        $funcloc01->created_at = Carbon::now();
        $funcloc01->save();

        $funcloc02 = new Funcloc();
        $funcloc02->id = 'FP-01-CFB-CSD-ESPR';
        $funcloc02->sort_field = 'TRAFO ESP BOILER 3';
        $funcloc02->created_at = Carbon::now();
        $funcloc02->save();

        $funcloc03 = new Funcloc();
        $funcloc03->id = 'FP-01-CH3-ALM-T089-P085';
        $funcloc03->sort_field = 'CH3.C06/M';
        $funcloc03->created_at = Carbon::now();
        $funcloc03->save();

        $funcloc04 = new Funcloc();
        $funcloc04->id = 'FP-01-CH5-ALM-T098-P121';
        $funcloc04->sort_field = '5AL-PC-01/M';
        $funcloc04->created_at = Carbon::now();
        $funcloc04->save();

        $funcloc05 = new Funcloc();
        $funcloc05->id = 'FP-01-ENC-TRF-PLN1';
        $funcloc05->sort_field = 'Trafo PLN1';
        $funcloc05->created_at = Carbon::now();
        $funcloc05->save();

        $funcloc06 = new Funcloc();
        $funcloc06->id = 'FP-01-FN1-CUT-RWD1';
        $funcloc06->sort_field = 'FIN1.YUELI';
        $funcloc06->created_at = Carbon::now();
        $funcloc06->save();

        $funcloc07 = new Funcloc();
        $funcloc07->id = 'FP-01-FN1-CUT-SC01-CRN1-HST1';
        $funcloc07->sort_field = 'SIMPLEX 1.9/HOISKONE 3.2T/GB/M';
        $funcloc07->created_at = Carbon::now();
        $funcloc07->save();

        $funcloc08 = new Funcloc();
        $funcloc08->id = 'FP-01-FN1-CUT-SC02';
        $funcloc08->sort_field = 'SIMPLEX 2.6';
        $funcloc08->created_at = Carbon::now();
        $funcloc08->save();

        $funcloc09 = new Funcloc();
        $funcloc09->id = 'FP-01-FN1-CUT-SC02-CRN1-HST1';
        $funcloc09->sort_field = 'SIMPLEX 2.6/HOISDEMAG';
        $funcloc09->created_at = Carbon::now();
        $funcloc09->save();

        $funcloc10 = new Funcloc();
        $funcloc10->id = 'FP-01-FN1-CUT-SC03';
        $funcloc10->sort_field = 'SIMPLEX 2.8';
        $funcloc10->created_at = Carbon::now();
        $funcloc10->save();

        $funcloc11 = new Funcloc();
        $funcloc11->id = 'FP-01-FN1-CUT-SC03-CRN1-HST1';
        $funcloc11->sort_field = 'SIMPLEX 2.8/HOIS DEMAG 5T/GB/M';
        $funcloc11->created_at = Carbon::now();
        $funcloc11->save();

        $funcloc12 = new Funcloc();
        $funcloc12->id = 'FP-01-FN1-CUT-SC04';
        $funcloc12->sort_field = 'DUPLEX 3.6';
        $funcloc12->created_at = Carbon::now();
        $funcloc12->save();

        $funcloc13 = new Funcloc();
        $funcloc13->id = 'FP-01-FN1-CUT-WRP1';
        $funcloc13->sort_field = 'WRAPPING 1';
        $funcloc13->created_at = Carbon::now();
        $funcloc13->save();

        $funcloc14 = new Funcloc();
        $funcloc14->id = 'FP-01-FN1-CUT-WRP2';
        $funcloc14->sort_field = 'WRAPPING 2';
        $funcloc14->created_at = Carbon::now();
        $funcloc14->save();

        $funcloc15 = new Funcloc();
        $funcloc15->id = 'FP-01-FN1-CUT-WRPR';
        $funcloc15->sort_field = 'WRAPPING ROLL';
        $funcloc15->created_at = Carbon::now();
        $funcloc15->save();

        $funcloc16 = new Funcloc();
        $funcloc16->id = 'FP-01-FN1-LUB-T353-P376';
        $funcloc16->sort_field = 'SIMPLEX 2.6/T(OS)/P1/M';
        $funcloc16->created_at = Carbon::now();
        $funcloc16->save();

        $funcloc17 = new Funcloc();
        $funcloc17->id = 'FP-01-FN1-LUB-T354-P378';
        $funcloc17->sort_field = 'SIMPLEX 2.8/T(OS)/P1/M';
        $funcloc17->created_at = Carbon::now();
        $funcloc17->save();

        $funcloc18 = new Funcloc();
        $funcloc18->id = 'FP-01-GT1';
        $funcloc18->sort_field = 'Trafo';
        $funcloc18->created_at = Carbon::now();
        $funcloc18->save();

        $funcloc19 = new Funcloc();
        $funcloc19->id = 'FP-01-GT1-TRF-PWP1';
        $funcloc19->sort_field = 'Trafo';
        $funcloc19->created_at = Carbon::now();
        $funcloc19->save();

        $funcloc20 = new Funcloc();
        $funcloc20->id = 'FP-01-GT1-TRF-UTY1';
        $funcloc20->sort_field = 'Trafo';
        $funcloc20->created_at = Carbon::now();
        $funcloc20->save();

        $funcloc21 = new Funcloc();
        $funcloc21->id = 'FP-01-GT2-TRF-PWP2';
        $funcloc21->sort_field = 'TR AUX GTG #1';
        $funcloc21->created_at = Carbon::now();
        $funcloc21->save();

        $funcloc22 = new Funcloc();
        $funcloc22->id = 'FP-01-GT2-TRF-UTY2';
        $funcloc22->sort_field = 'Trafo';
        $funcloc22->created_at = Carbon::now();
        $funcloc22->save();

        $funcloc23 = new Funcloc();
        $funcloc23->id = 'FP-01-GT3-BO5-CNSY-ESPR';
        $funcloc23->sort_field = 'TRAFO ESP BOILER 5';
        $funcloc23->created_at = Carbon::now();
        $funcloc23->save();

        $funcloc24 = new Funcloc();
        $funcloc24->id = 'FP-01-GT3-BO6-CNSY-ESPR';
        $funcloc24->sort_field = 'TRAFO ESP BOILER 6';
        $funcloc24->created_at = Carbon::now();
        $funcloc24->save();

        $funcloc25 = new Funcloc();
        $funcloc25->id = 'FP-01-GT3-TRB-TRF1';
        $funcloc25->sort_field = 'TRF1 START/STADNBY';
        $funcloc25->created_at = Carbon::now();
        $funcloc25->save();

        $funcloc26 = new Funcloc();
        $funcloc26->id = 'FP-01-IN1';
        $funcloc26->sort_field = 'TRAFO ENC';
        $funcloc26->created_at = Carbon::now();
        $funcloc26->save();

        $funcloc27 = new Funcloc();
        $funcloc27->id = 'FP-01-IN1-BIF-STDM-P050';
        $funcloc27->sort_field = 'IN1-BIF-STDM-P050/MBCP1/M-12A';
        $funcloc27->created_at = Carbon::now();
        $funcloc27->save();

        $funcloc28 = new Funcloc();
        $funcloc28->id = 'FP-01-IN1-TRF';
        $funcloc28->sort_field = 'Trafo';
        $funcloc28->created_at = Carbon::now();
        $funcloc28->save();

        $funcloc29 = new Funcloc();
        $funcloc29->id = 'FP-01-IN2-TRF';
        $funcloc29->sort_field = 'TR WWT';
        $funcloc29->created_at = Carbon::now();
        $funcloc29->save();

        $funcloc30 = new Funcloc();
        $funcloc30->id = 'FP-01-PM1-MCS-BL08';
        $funcloc30->sort_field = 'PM1.MCS.BLW2/M';
        $funcloc30->created_at = Carbon::now();
        $funcloc30->save();

        $funcloc31 = new Funcloc();
        $funcloc31->id = 'FP-01-PM1-STC-T252-VP13';
        $funcloc31->sort_field = 'PM1.STC.T(DN)';
        $funcloc31->created_at = Carbon::now();
        $funcloc31->save();

        $funcloc32 = new Funcloc();
        $funcloc32->id = 'FP-01-PM1-STC-T258-P264';
        $funcloc32->sort_field = 'PM1.STC.T(DN)';
        $funcloc32->created_at = Carbon::now();
        $funcloc32->save();

        $funcloc33 = new Funcloc();
        $funcloc33->id = 'FP-01-PM1-STC-T341-P359';
        $funcloc33->sort_field = 'PM1.STC.P1/M';
        $funcloc33->created_at = Carbon::now();
        $funcloc33->save();

        $funcloc34 = new Funcloc();
        $funcloc34->id = 'FP-01-PM1-VAS-T118-P159';
        $funcloc34->sort_field = 'PM1.VAC.T(DLG)/M';
        $funcloc34->created_at = Carbon::now();
        $funcloc34->save();

        $funcloc35 = new Funcloc();
        $funcloc35->id = 'FP-01-PM1-VAS-T119-P160';
        $funcloc35->sort_field = 'PM1.VAC.T(DLG)/M';
        $funcloc35->created_at = Carbon::now();
        $funcloc35->save();

        $funcloc36 = new Funcloc();
        $funcloc36->id = 'FP-01-PM1-VAS-T124-P165';
        $funcloc36->sort_field = 'PM1.VAC.VS6A/P1/M';
        $funcloc36->created_at = Carbon::now();
        $funcloc36->save();

        $funcloc37 = new Funcloc();
        $funcloc37->id = 'FP-01-PM1-VAS-VP05';
        $funcloc37->sort_field = 'PM1.VAC.VP1/GB/M';
        $funcloc37->created_at = Carbon::now();
        $funcloc37->save();

        $funcloc38 = new Funcloc();
        $funcloc38->id = 'FP-01-PM1-VAS-VP07';
        $funcloc38->sort_field = 'PM1.VAC.VP3/M';
        $funcloc38->created_at = Carbon::now();
        $funcloc38->save();

        $funcloc39 = new Funcloc();
        $funcloc39->id = 'FP-01-PM1-VAS-VP08';
        $funcloc39->sort_field = 'PM1.VAC.VP4/M';
        $funcloc39->created_at = Carbon::now();
        $funcloc39->save();

        $funcloc40 = new Funcloc();
        $funcloc40->id = 'FP-01-PM1-VAS-VP09';
        $funcloc40->sort_field = 'PM1.VAC.VP5/M';
        $funcloc40->created_at = Carbon::now();
        $funcloc40->save();

        $funcloc41 = new Funcloc();
        $funcloc41->id = 'FP-01-PM1-VAS-VP10';
        $funcloc41->sort_field = 'PM1.VAC.VP6/M';
        $funcloc41->created_at = Carbon::now();
        $funcloc41->save();

        $funcloc42 = new Funcloc();
        $funcloc42->id = 'FP-01-PM1-VAS-VP11';
        $funcloc42->sort_field = 'PM1.VAC.VP7/M';
        $funcloc42->created_at = Carbon::now();
        $funcloc42->save();

        $funcloc43 = new Funcloc();
        $funcloc43->id = 'FP-01-PM1-WET-FOR3-CM01';
        $funcloc43->sort_field = 'PM1.F3.CM01/GB/M';
        $funcloc43->created_at = Carbon::now();
        $funcloc43->save();

        $funcloc44 = new Funcloc();
        $funcloc44->id = 'FP-01-PM2-AP1-SR15';
        $funcloc44->sort_field = 'PM2.APP1.PS2/M';
        $funcloc44->created_at = Carbon::now();
        $funcloc44->save();

        $funcloc45 = new Funcloc();
        $funcloc45->id = 'FP-01-PM2-AP1-T043-A019';
        $funcloc45->sort_field = 'PM2.APP1.C1/AGT/M';
        $funcloc45->created_at = Carbon::now();
        $funcloc45->save();

        $funcloc46 = new Funcloc();
        $funcloc46->id = 'FP-01-PM2-AP1-T043-P059';
        $funcloc46->sort_field = 'PM2.APP1.C1/P1/M';
        $funcloc46->created_at = Carbon::now();
        $funcloc46->save();

        $funcloc47 = new Funcloc();
        $funcloc47->id = 'FP-01-PM2-AP1-T044-A020';
        $funcloc47->sort_field = 'PM2.APP1.C2/AGT/M';
        $funcloc47->created_at = Carbon::now();
        $funcloc47->save();

        $funcloc48 = new Funcloc();
        $funcloc48->id = 'FP-01-PM2-AP1-T045-P061';
        $funcloc48->sort_field = 'PM2.APP1.SL/P(FN)/M';
        $funcloc48->created_at = Carbon::now();
        $funcloc48->save();

        $funcloc49 = new Funcloc();
        $funcloc49->id = 'FP-01-PM2-AP1-T047-P064';
        $funcloc49->sort_field = 'PM2.APP1.C4/P2/M';
        $funcloc49->created_at = Carbon::now();
        $funcloc49->save();

        $funcloc50 = new Funcloc();
        $funcloc50->id = 'FP-01-PM2-AP2-T053-P070';
        $funcloc50->sort_field = 'PM2.APP2.T2/P1/M';
        $funcloc50->created_at = Carbon::now();
        $funcloc50->save();

        $funcloc51 = new Funcloc();
        $funcloc51->id = 'FP-01-PM2-CUT-FDR1-BL20';
        $funcloc51->sort_field = 'PM2.RE(BH).FDR.BLW/M';
        $funcloc51->created_at = Carbon::now();
        $funcloc51->save();

        $funcloc52 = new Funcloc();
        $funcloc52->id = 'FP-01-PM2-CUT-RDR1-BL21';
        $funcloc52->sort_field = 'PM2.RE(BH).RDR.BLW/M';
        $funcloc52->created_at = Carbon::now();
        $funcloc52->save();

        $funcloc53 = new Funcloc();
        $funcloc53->id = 'FP-01-PM2-CUT-RWD1';
        $funcloc53->sort_field = 'PM2.RE(BH).UNW/BLW/M';
        $funcloc53->created_at = Carbon::now();
        $funcloc53->save();

        $funcloc54 = new Funcloc();
        $funcloc54->id = 'FP-01-PM2-CUT-RWD1-BL22';
        $funcloc54->sort_field = 'PM2.RE(BH).BLW/M';
        $funcloc54->created_at = Carbon::now();
        $funcloc54->save();

        $funcloc55 = new Funcloc();
        $funcloc55->id = 'FP-01-PM2-LUB-T129-P126';
        $funcloc55->sort_field = 'M1-2641';
        $funcloc55->created_at = Carbon::now();
        $funcloc55->save();

        $funcloc56 = new Funcloc();
        $funcloc56->id = 'FP-01-PM2-REL-PPRL-CYL1';
        $funcloc56->sort_field = 'PM2.PPR.CYL/GB/M';
        $funcloc56->created_at = Carbon::now();
        $funcloc56->save();

        $funcloc57 = new Funcloc();
        $funcloc57->id = 'FP-01-PM2-VAS-BL05';
        $funcloc57->sort_field = 'PM2.VAC.BLW5/M';
        $funcloc57->created_at = Carbon::now();
        $funcloc57->save();

        $funcloc58 = new Funcloc();
        $funcloc58->id = 'FP-01-PM2-VAS-T081-P084';
        $funcloc58->sort_field = 'PM2.VAC.T(DLG)5/P1/M';
        $funcloc58->created_at = Carbon::now();
        $funcloc58->save();

        $funcloc59 = new Funcloc();
        $funcloc59->id = 'FP-01-PM2-VAS-T092-P086';
        $funcloc59->sort_field = 'PM2.VAC.T(DLG)/M';
        $funcloc59->created_at = Carbon::now();
        $funcloc59->save();

        $funcloc60 = new Funcloc();
        $funcloc60->id = 'FP-01-PM2-WET-TPWR-FMR1';
        $funcloc60->sort_field = 'PM2.TW.FMR/GB/M';
        $funcloc60->created_at = Carbon::now();
        $funcloc60->save();

        $funcloc61 = new Funcloc();
        $funcloc61->id = 'FP-01-PM3-BRS-T037-P061';
        $funcloc61->sort_field = 'PM3-BR01/P47/M';
        $funcloc61->created_at = Carbon::now();
        $funcloc61->save();

        $funcloc62 = new Funcloc();
        $funcloc62->id = 'FP-01-PM3-REL-PPRL-PRAR';
        $funcloc62->sort_field = 'PM3.REEL.PRAR/GM';
        $funcloc62->created_at = Carbon::now();
        $funcloc62->save();

        $funcloc63 = new Funcloc();
        $funcloc63->id = 'FP-01-PM5-VAS-BL04';
        $funcloc63->sort_field = 'PM5.FAN-2/M';
        $funcloc63->created_at = Carbon::now();
        $funcloc63->save();

        $funcloc64 = new Funcloc();
        $funcloc64->id = 'FP-01-PM7-CUT-RWD1';
        $funcloc64->sort_field = 'PM7.SLITTER 1/M';
        $funcloc64->created_at = Carbon::now();
        $funcloc64->save();

        $funcloc65 = new Funcloc();
        $funcloc65->id = 'FP-01-PM7-CUT-RWD10';
        $funcloc65->sort_field = 'PM7.SLITER 10/M';
        $funcloc65->created_at = Carbon::now();
        $funcloc65->save();

        $funcloc66 = new Funcloc();
        $funcloc66->id = 'FP-01-PM7-CUT-RWD11';
        $funcloc66->sort_field = 'PM7.SLITER 11/M';
        $funcloc66->created_at = Carbon::now();
        $funcloc66->save();

        $funcloc67 = new Funcloc();
        $funcloc67->id = 'FP-01-PM7-DRY-GRP6-DC40';
        $funcloc67->sort_field = 'PM7.G6.DYC40D/M';
        $funcloc67->created_at = Carbon::now();
        $funcloc67->save();

        $funcloc68 = new Funcloc();
        $funcloc68->id = 'FP-01-PM7-DRY-GRP6-DC41';
        $funcloc68->sort_field = 'PM7.G6.DYC41D/M';
        $funcloc68->created_at = Carbon::now();
        $funcloc68->save();

        $funcloc69 = new Funcloc();
        $funcloc69->id = 'FP-01-PM7-DRY-SZPR-PR03';
        $funcloc69->sort_field = 'PM7.SIZE PRESS PAPER ROLL';
        $funcloc69->created_at = Carbon::now();
        $funcloc69->save();

        $funcloc70 = new Funcloc();
        $funcloc70->id = 'FP-01-PM7-VAS-VP13';
        $funcloc70->sort_field = 'PM7.VAS/VP-18101000/M';
        $funcloc70->created_at = Carbon::now();
        $funcloc70->save();

        $funcloc71 = new Funcloc();
        $funcloc71->id = 'FP-01-PM8-PRS-PRS2-MD05';
        $funcloc71->sort_field = 'PM8/PRS-PRS2-MD05';
        $funcloc71->created_at = Carbon::now();
        $funcloc71->save();

        $funcloc72 = new Funcloc();
        $funcloc72->id = 'FP-01-SP1-CLD-T081-P105';
        $funcloc72->sort_field = 'SP1.CL.C10/P1/M';
        $funcloc72->created_at = Carbon::now();
        $funcloc72->save();

        $funcloc73 = new Funcloc();
        $funcloc73->id = 'FP-01-SP1-CPO-T015-P026';
        $funcloc73->sort_field = 'SP1.CP.C13/P2/M';
        $funcloc73->created_at = Carbon::now();
        $funcloc73->save();

        $funcloc74 = new Funcloc();
        $funcloc74->id = 'FP-01-SP1-CPO-T018-P029';
        $funcloc74->sort_field = 'SP1.CP.C5A/P1/M';
        $funcloc74->created_at = Carbon::now();
        $funcloc74->save();

        $funcloc75 = new Funcloc();
        $funcloc75->id = 'FP-01-SP1-MXW-RF04';
        $funcloc75->sort_field = 'SP1.UK.DDR3/M';
        $funcloc75->created_at = Carbon::now();
        $funcloc75->save();

        $funcloc76 = new Funcloc();
        $funcloc76->id = 'FP-01-SP1-MXW-T052-P070';
        $funcloc76->sort_field = 'SP1.MW.T4/P1/M';
        $funcloc76->created_at = Carbon::now();
        $funcloc76->save();

        $funcloc77 = new Funcloc();
        $funcloc77->id = 'FP-01-SP1-UKP-RF07';
        $funcloc77->sort_field = 'SP1.MW.DDR1/M';
        $funcloc77->created_at = Carbon::now();
        $funcloc77->save();

        $funcloc78 = new Funcloc();
        $funcloc78->id = 'FP-01-SP2-NDL-SR12';
        $funcloc78->sort_field = 'SP2.ND.PS(F)1/M';
        $funcloc78->created_at = Carbon::now();
        $funcloc78->save();

        $funcloc79 = new Funcloc();
        $funcloc79->id = 'FP-01-SP2-NDL-T027-P041';
        $funcloc79->sort_field = 'SP2.ND.C3A/P2/M';
        $funcloc79->created_at = Carbon::now();
        $funcloc79->save();

        $funcloc80 = new Funcloc();
        $funcloc80->id = 'FP-01-SP2-OCC-T001-P003';
        $funcloc80->sort_field = 'SP2.OC.C1/P1/M';
        $funcloc80->created_at = Carbon::now();
        $funcloc80->save();

        $funcloc81 = new Funcloc();
        $funcloc81->id = 'FP-01-SP2-WRS-T155-P161';
        $funcloc81->sort_field = 'SP2.WRS.T1/(SE)/M';
        $funcloc81->created_at = Carbon::now();
        $funcloc81->save();

        $funcloc82 = new Funcloc();
        $funcloc82->id = 'FP-01-SP3-OCC-T025-P038';
        $funcloc82->sort_field = 'SP3.C26/P53/M';
        $funcloc82->created_at = Carbon::now();
        $funcloc82->save();

        $funcloc83 = new Funcloc();
        $funcloc83->id = 'FP-01-SP3-OCC-TH08-P077';
        $funcloc83->sort_field = 'SP3.P042/M';
        $funcloc83->created_at = Carbon::now();
        $funcloc83->save();

        $funcloc84 = new Funcloc();
        $funcloc84->id = 'FP-01-SP3-RJS-T092-P092';
        $funcloc84->sort_field = 'PM3.SUM.P70';
        $funcloc84->created_at = Carbon::now();
        $funcloc84->save();

        $funcloc85 = new Funcloc();
        $funcloc85->id = 'FP-01-SP5-OCC-FR01';
        $funcloc85->sort_field = 'SP5.M-21/M';
        $funcloc85->created_at = Carbon::now();
        $funcloc85->save();

        $funcloc86 = new Funcloc();
        $funcloc86->id = 'FP-01-WW1-CHP-A400';
        $funcloc86->sort_field = 'WW1.CHP.T(PLM)';
        $funcloc86->created_at = Carbon::now();
        $funcloc86->save();

        $funcloc87 = new Funcloc();
        $funcloc87->id = 'FP-01-WW2-SCD-P151';
        $funcloc87->sort_field = 'WW2.SCD.A/O.C6/P2(WP-52)/M';
        $funcloc87->created_at = Carbon::now();
        $funcloc87->save();

        $funcloc88 = new Funcloc();
        $funcloc88->id = 'FP-01-PM3';
        $funcloc88->sort_field = 'PM3';
        $funcloc88->created_at = Carbon::now();
        $funcloc88->save();

        $funcloc89 = new Funcloc();
        $funcloc89->id = 'FP-01-SP7-OCC-RF03';
        $funcloc89->sort_field = 'M.2.36/M';
        $funcloc89->created_at = Carbon::now();
        $funcloc89->save();
    }
}
