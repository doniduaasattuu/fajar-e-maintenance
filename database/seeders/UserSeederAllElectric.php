<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeederAllElectric extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_role')->delete();
        DB::table('users')->delete();

        $user00 = new User();
        $user00->nik = '55000154';
        $user00->password = '@Fajarpaper123';
        $user00->fullname = 'Doni Darmawan';
        $user00->department = 'EI2';
        $user00->phone_number = '08983456945';
        $user00->created_at = Carbon::now();
        $user00->updated_at = null;
        $user00->save();

        $user01 = new User();
        $user01->nik = '31100003';
        $user01->password = '@Fajarpaper123';
        $user01->fullname = 'Arief Sunari';
        $user01->department = 'EI2';
        $user01->phone_number = '12345678910';
        $user01->created_at = Carbon::now();
        $user01->updated_at = null;
        $user01->save();

        $user02 = new User();
        $user02->nik = '31100005';
        $user02->password = '@Fajarpaper123';
        $user02->fullname = 'Asep Suryana';
        $user02->department = 'EI1';
        $user02->phone_number = '12345678910';
        $user02->created_at = Carbon::now();
        $user02->updated_at = null;
        $user02->save();

        $user03 = new User();
        $user03->nik = '31100011';
        $user03->password = '@Fajarpaper123';
        $user03->fullname = 'Eko Nugroho';
        $user03->department = 'EI1';
        $user03->phone_number = '12345678910';
        $user03->created_at = Carbon::now();
        $user03->updated_at = null;
        $user03->save();

        $user04 = new User();
        $user04->nik = '31100017';
        $user04->password = '@Fajarpaper123';
        $user04->fullname = 'Haris Wahyudi';
        $user04->department = 'EI1';
        $user04->phone_number = '12345678910';
        $user04->created_at = Carbon::now();
        $user04->updated_at = null;
        $user04->save();

        $user05 = new User();
        $user05->nik = '31100019';
        $user05->password = '@Fajarpaper123';
        $user05->fullname = 'Jiyantoro';
        $user05->department = 'EI7';
        $user05->phone_number = '12345678910';
        $user05->created_at = Carbon::now();
        $user05->updated_at = null;
        $user05->save();

        $user06 = new User();
        $user06->nik = '31100027';
        $user06->password = '@Fajarpaper123';
        $user06->fullname = 'Mulyadi';
        $user06->department = 'EI1';
        $user06->phone_number = '12345678910';
        $user06->created_at = Carbon::now();
        $user06->updated_at = null;
        $user06->save();

        $user07 = new User();
        $user07->nik = '31100029';
        $user07->password = '@Fajarpaper123';
        $user07->fullname = 'Muslim';
        $user07->department = 'EI5';
        $user07->phone_number = '12345678910';
        $user07->created_at = Carbon::now();
        $user07->updated_at = null;
        $user07->save();

        $user08 = new User();
        $user08->nik = '31100031';
        $user08->password = '@Fajarpaper123';
        $user08->fullname = 'Obos Ridwansyah';
        $user08->department = 'EI1';
        $user08->phone_number = '12345678910';
        $user08->created_at = Carbon::now();
        $user08->updated_at = null;
        $user08->save();

        $user09 = new User();
        $user09->nik = '31100033';
        $user09->password = '@Fajarpaper123';
        $user09->fullname = 'Riki Arliandi';
        $user09->department = 'EI1';
        $user09->phone_number = '12345678910';
        $user09->created_at = Carbon::now();
        $user09->updated_at = null;
        $user09->save();

        $user10 = new User();
        $user10->nik = '31100037';
        $user10->password = '@Fajarpaper123';
        $user10->fullname = 'Rusdi';
        $user10->department = 'EI1';
        $user10->phone_number = '12345678910';
        $user10->created_at = Carbon::now();
        $user10->updated_at = null;
        $user10->save();

        $user11 = new User();
        $user11->nik = '31100051';
        $user11->password = '@Fajarpaper123';
        $user11->fullname = 'Surahmin';
        $user11->department = 'EI1';
        $user11->phone_number = '12345678910';
        $user11->created_at = Carbon::now();
        $user11->updated_at = null;
        $user11->save();

        $user12 = new User();
        $user12->nik = '31100053';
        $user12->password = '@Fajarpaper123';
        $user12->fullname = 'Syahrizal';
        $user12->department = 'EI1';
        $user12->phone_number = '12345678910';
        $user12->created_at = Carbon::now();
        $user12->updated_at = null;
        $user12->save();

        $user13 = new User();
        $user13->nik = '31100056';
        $user13->password = '@Fajarpaper123';
        $user13->fullname = 'Wandi Sadeli P.';
        $user13->department = 'EI1';
        $user13->phone_number = '12345678910';
        $user13->created_at = Carbon::now();
        $user13->updated_at = null;
        $user13->save();

        $user14 = new User();
        $user14->nik = '31100064';
        $user14->password = '@Fajarpaper123';
        $user14->fullname = 'Nachtiar';
        $user14->department = 'EI1';
        $user14->phone_number = '12345678910';
        $user14->created_at = Carbon::now();
        $user14->updated_at = null;
        $user14->save();

        $user15 = new User();
        $user15->nik = '31100075';
        $user15->password = '@Fajarpaper123';
        $user15->fullname = 'Suwaji';
        $user15->department = 'EI1';
        $user15->phone_number = '12345678910';
        $user15->created_at = Carbon::now();
        $user15->updated_at = null;
        $user15->save();

        $user16 = new User();
        $user16->nik = '31100107';
        $user16->password = '@Fajarpaper123';
        $user16->fullname = 'Sartika';
        $user16->department = 'EI1';
        $user16->phone_number = '12345678910';
        $user16->created_at = Carbon::now();
        $user16->updated_at = null;
        $user16->save();

        $user17 = new User();
        $user17->nik = '31100109';
        $user17->password = '@Fajarpaper123';
        $user17->fullname = 'Karsa';
        $user17->department = 'EI1';
        $user17->phone_number = '12345678910';
        $user17->created_at = Carbon::now();
        $user17->updated_at = null;
        $user17->save();

        $user18 = new User();
        $user18->nik = '31100113';
        $user18->password = '@Fajarpaper123';
        $user18->fullname = 'Mujiyanto';
        $user18->department = 'EI1';
        $user18->phone_number = '12345678910';
        $user18->created_at = Carbon::now();
        $user18->updated_at = null;
        $user18->save();

        $user19 = new User();
        $user19->nik = '31100156';
        $user19->password = '@Fajarpaper123';
        $user19->fullname = 'Suryanto';
        $user19->department = 'EI1';
        $user19->phone_number = '12345678910';
        $user19->created_at = Carbon::now();
        $user19->updated_at = null;
        $user19->save();

        $user20 = new User();
        $user20->nik = '31100160';
        $user20->password = '@Fajarpaper123';
        $user20->fullname = 'Lili';
        $user20->department = 'EI1';
        $user20->phone_number = '12345678910';
        $user20->created_at = Carbon::now();
        $user20->updated_at = null;
        $user20->save();

        $user21 = new User();
        $user21->nik = '31100162';
        $user21->password = '@Fajarpaper123';
        $user21->fullname = 'Hasan Badri';
        $user21->department = 'EI1';
        $user21->phone_number = '12345678910';
        $user21->created_at = Carbon::now();
        $user21->updated_at = null;
        $user21->save();

        $user22 = new User();
        $user22->nik = '31100171';
        $user22->password = '@Fajarpaper123';
        $user22->fullname = 'Darminto';
        $user22->department = 'EI1';
        $user22->phone_number = '12345678910';
        $user22->created_at = Carbon::now();
        $user22->updated_at = null;
        $user22->save();

        $user23 = new User();
        $user23->nik = '31100172';
        $user23->password = '@Fajarpaper123';
        $user23->fullname = 'Haryanto';
        $user23->department = 'EI1';
        $user23->phone_number = '12345678910';
        $user23->created_at = Carbon::now();
        $user23->updated_at = null;
        $user23->save();

        $user24 = new User();
        $user24->nik = '31100174';
        $user24->password = '@Fajarpaper123';
        $user24->fullname = 'Christofan';
        $user24->department = 'EI1';
        $user24->phone_number = '12345678910';
        $user24->created_at = Carbon::now();
        $user24->updated_at = null;
        $user24->save();

        $user25 = new User();
        $user25->nik = '31100175';
        $user25->password = '@Fajarpaper123';
        $user25->fullname = 'Joko Haryanto';
        $user25->department = 'EI1';
        $user25->phone_number = '12345678910';
        $user25->created_at = Carbon::now();
        $user25->updated_at = null;
        $user25->save();

        $user26 = new User();
        $user26->nik = '31100177';
        $user26->password = '@Fajarpaper123';
        $user26->fullname = 'Purwanto';
        $user26->department = 'EI1';
        $user26->phone_number = '12345678910';
        $user26->created_at = Carbon::now();
        $user26->updated_at = null;
        $user26->save();

        $user27 = new User();
        $user27->nik = '31100178';
        $user27->password = '@Fajarpaper123';
        $user27->fullname = 'Moh. Amron Amirul';
        $user27->department = 'EI1';
        $user27->phone_number = '12345678910';
        $user27->created_at = Carbon::now();
        $user27->updated_at = null;
        $user27->save();

        $user28 = new User();
        $user28->nik = '31100182';
        $user28->password = '@Fajarpaper123';
        $user28->fullname = 'Muhammad Ridwan';
        $user28->department = 'EI1';
        $user28->phone_number = '12345678910';
        $user28->created_at = Carbon::now();
        $user28->updated_at = null;
        $user28->save();

        $user29 = new User();
        $user29->nik = '31100186';
        $user29->password = '@Fajarpaper123';
        $user29->fullname = 'Maruba Sinaga';
        $user29->department = 'EI1';
        $user29->phone_number = '12345678910';
        $user29->created_at = Carbon::now();
        $user29->updated_at = null;
        $user29->save();

        $user30 = new User();
        $user30->nik = '31100188';
        $user30->password = '@Fajarpaper123';
        $user30->fullname = 'Nanang Purwanto';
        $user30->department = 'EI1';
        $user30->phone_number = '12345678910';
        $user30->created_at = Carbon::now();
        $user30->updated_at = null;
        $user30->save();

        $user31 = new User();
        $user31->nik = '31611021';
        $user31->password = '@Fajarpaper123';
        $user31->fullname = 'Dedy Indra Gunawan';
        $user31->department = 'EI1';
        $user31->phone_number = '12345678910';
        $user31->created_at = Carbon::now();
        $user31->updated_at = null;
        $user31->save();

        $user32 = new User();
        $user32->nik = '31612012';
        $user32->password = '@Fajarpaper123';
        $user32->fullname = 'Agus Candra S.';
        $user32->department = 'EI1';
        $user32->phone_number = '12345678910';
        $user32->created_at = Carbon::now();
        $user32->updated_at = null;
        $user32->save();

        $user33 = new User();
        $user33->nik = '31612016';
        $user33->password = '@Fajarpaper123';
        $user33->fullname = 'Yanuar Cholis P.';
        $user33->department = 'EI1';
        $user33->phone_number = '12345678910';
        $user33->created_at = Carbon::now();
        $user33->updated_at = null;
        $user33->save();

        $user34 = new User();
        $user34->nik = '31701003';
        $user34->password = '@Fajarpaper123';
        $user34->fullname = 'Dimas Bagusing Penggalih';
        $user34->department = 'EI1';
        $user34->phone_number = '12345678910';
        $user34->created_at = Carbon::now();
        $user34->updated_at = null;
        $user34->save();

        $user35 = new User();
        $user35->nik = '31702024';
        $user35->password = '@Fajarpaper123';
        $user35->fullname = 'Muhammad Aji Sandjaya';
        $user35->department = 'EI1';
        $user35->phone_number = '12345678910';
        $user35->created_at = Carbon::now();
        $user35->updated_at = null;
        $user35->save();

        $user36 = new User();
        $user36->nik = '31703016';
        $user36->password = '@Fajarpaper123';
        $user36->fullname = 'Henry Sugara';
        $user36->department = 'EI1';
        $user36->phone_number = '12345678910';
        $user36->created_at = Carbon::now();
        $user36->updated_at = null;
        $user36->save();

        $user37 = new User();
        $user37->nik = '31705012';
        $user37->password = '@Fajarpaper123';
        $user37->fullname = 'Hariyadi';
        $user37->department = 'EI1';
        $user37->phone_number = '12345678910';
        $user37->created_at = Carbon::now();
        $user37->updated_at = null;
        $user37->save();

        $user38 = new User();
        $user38->nik = '31708012';
        $user38->password = '@Fajarpaper123';
        $user38->fullname = 'Imam Achmad Ashari';
        $user38->department = 'EI1';
        $user38->phone_number = '12345678910';
        $user38->created_at = Carbon::now();
        $user38->updated_at = null;
        $user38->save();

        $user39 = new User();
        $user39->nik = '31708041';
        $user39->password = '@Fajarpaper123';
        $user39->fullname = 'Tri Wahyu Aji';
        $user39->department = 'EI1';
        $user39->phone_number = '12345678910';
        $user39->created_at = Carbon::now();
        $user39->updated_at = null;
        $user39->save();

        $user40 = new User();
        $user40->nik = '31708067';
        $user40->password = '@Fajarpaper123';
        $user40->fullname = 'Asep Rudiatuloh';
        $user40->department = 'EI1';
        $user40->phone_number = '12345678910';
        $user40->created_at = Carbon::now();
        $user40->updated_at = null;
        $user40->save();

        $user41 = new User();
        $user41->nik = '31802014';
        $user41->password = '@Fajarpaper123';
        $user41->fullname = 'Hafid Abdul Azis';
        $user41->department = 'EI1';
        $user41->phone_number = '12345678910';
        $user41->created_at = Carbon::now();
        $user41->updated_at = null;
        $user41->save();

        $user42 = new User();
        $user42->nik = '31802016';
        $user42->password = '@Fajarpaper123';
        $user42->fullname = 'Gusnandar Sengkeh';
        $user42->department = 'EI1';
        $user42->phone_number = '12345678910';
        $user42->created_at = Carbon::now();
        $user42->updated_at = null;
        $user42->save();

        $user43 = new User();
        $user43->nik = '31803011';
        $user43->password = '@Fajarpaper123';
        $user43->fullname = 'Dedi Saputra';
        $user43->department = 'EI1';
        $user43->phone_number = '12345678910';
        $user43->created_at = Carbon::now();
        $user43->updated_at = null;
        $user43->save();

        $user44 = new User();
        $user44->nik = '31804006';
        $user44->password = '@Fajarpaper123';
        $user44->fullname = 'Fauzan Abdillah';
        $user44->department = 'EI1';
        $user44->phone_number = '12345678910';
        $user44->created_at = Carbon::now();
        $user44->updated_at = null;
        $user44->save();

        $user45 = new User();
        $user45->nik = '31804007';
        $user45->password = '@Fajarpaper123';
        $user45->fullname = 'Andi Kurnia Mulyana';
        $user45->department = 'EI1';
        $user45->phone_number = '12345678910';
        $user45->created_at = Carbon::now();
        $user45->updated_at = null;
        $user45->save();

        $user46 = new User();
        $user46->nik = '31804008';
        $user46->password = '@Fajarpaper123';
        $user46->fullname = 'Jaka Kumoro';
        $user46->department = 'EI1';
        $user46->phone_number = '12345678910';
        $user46->created_at = Carbon::now();
        $user46->updated_at = null;
        $user46->save();

        $user47 = new User();
        $user47->nik = '31804009';
        $user47->password = '@Fajarpaper123';
        $user47->fullname = 'Teguh Purwanto';
        $user47->department = 'EI1';
        $user47->phone_number = '12345678910';
        $user47->created_at = Carbon::now();
        $user47->updated_at = null;
        $user47->save();

        $user48 = new User();
        $user48->nik = '31804024';
        $user48->password = '@Fajarpaper123';
        $user48->fullname = 'Johan Guszali';
        $user48->department = 'EI1';
        $user48->phone_number = '12345678910';
        $user48->created_at = Carbon::now();
        $user48->updated_at = null;
        $user48->save();

        $user49 = new User();
        $user49->nik = '31809017';
        $user49->password = '@Fajarpaper123';
        $user49->fullname = 'Adis Fariedsi';
        $user49->department = 'EI1';
        $user49->phone_number = '12345678910';
        $user49->created_at = Carbon::now();
        $user49->updated_at = null;
        $user49->save();

        $user50 = new User();
        $user50->nik = '31810020';
        $user50->password = '@Fajarpaper123';
        $user50->fullname = 'Chaerul Umam';
        $user50->department = 'EI1';
        $user50->phone_number = '12345678910';
        $user50->created_at = Carbon::now();
        $user50->updated_at = null;
        $user50->save();

        $user51 = new User();
        $user51->nik = '31811016';
        $user51->password = '@Fajarpaper123';
        $user51->fullname = 'Prima Hendra Kusuma';
        $user51->department = 'EI1';
        $user51->phone_number = '12345678910';
        $user51->created_at = Carbon::now();
        $user51->updated_at = null;
        $user51->save();

        $user52 = new User();
        $user52->nik = '31811026';
        $user52->password = '@Fajarpaper123';
        $user52->fullname = 'Dwi Waris Pratama';
        $user52->department = 'EI1';
        $user52->phone_number = '12345678910';
        $user52->created_at = Carbon::now();
        $user52->updated_at = null;
        $user52->save();

        $user53 = new User();
        $user53->nik = '31811028';
        $user53->password = '@Fajarpaper123';
        $user53->fullname = 'Abdul Malik';
        $user53->department = 'EI1';
        $user53->phone_number = '12345678910';
        $user53->created_at = Carbon::now();
        $user53->updated_at = null;
        $user53->save();

        $user54 = new User();
        $user54->nik = '31811029';
        $user54->password = '@Fajarpaper123';
        $user54->fullname = 'Totok Budiyanto';
        $user54->department = 'EI1';
        $user54->phone_number = '12345678910';
        $user54->created_at = Carbon::now();
        $user54->updated_at = null;
        $user54->save();

        $user55 = new User();
        $user55->nik = '31811051';
        $user55->password = '@Fajarpaper123';
        $user55->fullname = 'Edo Maheswara';
        $user55->department = 'EI1';
        $user55->phone_number = '12345678910';
        $user55->created_at = Carbon::now();
        $user55->updated_at = null;
        $user55->save();

        $user56 = new User();
        $user56->nik = '31901010';
        $user56->password = '@Fajarpaper123';
        $user56->fullname = 'Akhmad Yuprizal';
        $user56->department = 'EI1';
        $user56->phone_number = '12345678910';
        $user56->created_at = Carbon::now();
        $user56->updated_at = null;
        $user56->save();

        $user57 = new User();
        $user57->nik = '31901029';
        $user57->password = '@Fajarpaper123';
        $user57->fullname = 'Sukiryo';
        $user57->department = 'EI1';
        $user57->phone_number = '12345678910';
        $user57->created_at = Carbon::now();
        $user57->updated_at = null;
        $user57->save();

        $user58 = new User();
        $user58->nik = '31902002';
        $user58->password = '@Fajarpaper123';
        $user58->fullname = 'Rizal Prasetya Nugraha';
        $user58->department = 'EI1';
        $user58->phone_number = '12345678910';
        $user58->created_at = Carbon::now();
        $user58->updated_at = null;
        $user58->save();

        $user59 = new User();
        $user59->nik = '31902012';
        $user59->password = '@Fajarpaper123';
        $user59->fullname = 'Fredy Indra Prasetyo';
        $user59->department = 'EI1';
        $user59->phone_number = '12345678910';
        $user59->created_at = Carbon::now();
        $user59->updated_at = null;
        $user59->save();

        $user60 = new User();
        $user60->nik = '31903006';
        $user60->password = '@Fajarpaper123';
        $user60->fullname = 'Lucky Suwito';
        $user60->department = 'EI1';
        $user60->phone_number = '12345678910';
        $user60->created_at = Carbon::now();
        $user60->updated_at = null;
        $user60->save();

        $user61 = new User();
        $user61->nik = '31903007';
        $user61->password = '@Fajarpaper123';
        $user61->fullname = 'Yuan Lucky Prasetyo Winarno';
        $user61->department = 'EI1';
        $user61->phone_number = '12345678910';
        $user61->created_at = Carbon::now();
        $user61->updated_at = null;
        $user61->save();

        $user62 = new User();
        $user62->nik = '31903029';
        $user62->password = '@Fajarpaper123';
        $user62->fullname = 'Narendra Rahman Handwi';
        $user62->department = 'EI1';
        $user62->phone_number = '12345678910';
        $user62->created_at = Carbon::now();
        $user62->updated_at = null;
        $user62->save();

        $user63 = new User();
        $user63->nik = '31903032';
        $user63->password = '@Fajarpaper123';
        $user63->fullname = 'Tomy Setya Dianto';
        $user63->department = 'EI1';
        $user63->phone_number = '12345678910';
        $user63->created_at = Carbon::now();
        $user63->updated_at = null;
        $user63->save();

        $user64 = new User();
        $user64->nik = '31903034';
        $user64->password = '@Fajarpaper123';
        $user64->fullname = 'Suprihatin';
        $user64->department = 'EI1';
        $user64->phone_number = '12345678910';
        $user64->created_at = Carbon::now();
        $user64->updated_at = null;
        $user64->save();

        $user65 = new User();
        $user65->nik = '31904008';
        $user65->password = '@Fajarpaper123';
        $user65->fullname = 'Kukuh Budi Setiawan';
        $user65->department = 'EI1';
        $user65->phone_number = '12345678910';
        $user65->created_at = Carbon::now();
        $user65->updated_at = null;
        $user65->save();

        $user66 = new User();
        $user66->nik = '31905034';
        $user66->password = '@Fajarpaper123';
        $user66->fullname = 'Agung Setiawan';
        $user66->department = 'EI1';
        $user66->phone_number = '12345678910';
        $user66->created_at = Carbon::now();
        $user66->updated_at = null;
        $user66->save();

        $user67 = new User();
        $user67->nik = '31905037';
        $user67->password = '@Fajarpaper123';
        $user67->fullname = 'Gunanto';
        $user67->department = 'EI1';
        $user67->phone_number = '12345678910';
        $user67->created_at = Carbon::now();
        $user67->updated_at = null;
        $user67->save();

        $user68 = new User();
        $user68->nik = '31905044';
        $user68->password = '@Fajarpaper123';
        $user68->fullname = 'Diqi Prianto';
        $user68->department = 'EI1';
        $user68->phone_number = '12345678910';
        $user68->created_at = Carbon::now();
        $user68->updated_at = null;
        $user68->save();

        $user69 = new User();
        $user69->nik = '31905047';
        $user69->password = '@Fajarpaper123';
        $user69->fullname = 'Ilham Mugniyarachmangustama';
        $user69->department = 'EI1';
        $user69->phone_number = '12345678910';
        $user69->created_at = Carbon::now();
        $user69->updated_at = null;
        $user69->save();

        $user70 = new User();
        $user70->nik = '31905048';
        $user70->password = '@Fajarpaper123';
        $user70->fullname = 'Naufal Bima Alfianto';
        $user70->department = 'EI1';
        $user70->phone_number = '12345678910';
        $user70->created_at = Carbon::now();
        $user70->updated_at = null;
        $user70->save();

        $user71 = new User();
        $user71->nik = '31905050';
        $user71->password = '@Fajarpaper123';
        $user71->fullname = 'Moh. Dikta Rizky Alkadri';
        $user71->department = 'EI1';
        $user71->phone_number = '12345678910';
        $user71->created_at = Carbon::now();
        $user71->updated_at = null;
        $user71->save();

        $user72 = new User();
        $user72->nik = '31905051';
        $user72->password = '@Fajarpaper123';
        $user72->fullname = 'Yuda Septiawan';
        $user72->department = 'EI1';
        $user72->phone_number = '12345678910';
        $user72->created_at = Carbon::now();
        $user72->updated_at = null;
        $user72->save();

        $user73 = new User();
        $user73->nik = '31905087';
        $user73->password = '@Fajarpaper123';
        $user73->fullname = 'Hardono';
        $user73->department = 'EI1';
        $user73->phone_number = '12345678910';
        $user73->created_at = Carbon::now();
        $user73->updated_at = null;
        $user73->save();

        $user74 = new User();
        $user74->nik = '31907048';
        $user74->password = '@Fajarpaper123';
        $user74->fullname = 'Denis Capirosi Firmansyah';
        $user74->department = 'EI1';
        $user74->phone_number = '12345678910';
        $user74->created_at = Carbon::now();
        $user74->updated_at = null;
        $user74->save();

        $user75 = new User();
        $user75->nik = '31907074';
        $user75->password = '@Fajarpaper123';
        $user75->fullname = 'Muhamad Sulistiyo';
        $user75->department = 'EI1';
        $user75->phone_number = '12345678910';
        $user75->created_at = Carbon::now();
        $user75->updated_at = null;
        $user75->save();

        $user76 = new User();
        $user76->nik = '31907080';
        $user76->password = '@Fajarpaper123';
        $user76->fullname = 'Donie Winata';
        $user76->department = 'EI1';
        $user76->phone_number = '12345678910';
        $user76->created_at = Carbon::now();
        $user76->updated_at = null;
        $user76->save();

        $user77 = new User();
        $user77->nik = '31908024';
        $user77->password = '@Fajarpaper123';
        $user77->fullname = 'Leonardus Dwi Niandityo';
        $user77->department = 'EI1';
        $user77->phone_number = '12345678910';
        $user77->created_at = Carbon::now();
        $user77->updated_at = null;
        $user77->save();

        $user78 = new User();
        $user78->nik = '31909001';
        $user78->password = '@Fajarpaper123';
        $user78->fullname = 'Herianto As Purba';
        $user78->department = 'EI1';
        $user78->phone_number = '12345678910';
        $user78->created_at = Carbon::now();
        $user78->updated_at = null;
        $user78->save();

        $user79 = new User();
        $user79->nik = '31909022';
        $user79->password = '@Fajarpaper123';
        $user79->fullname = 'Aditiya Pamungkas';
        $user79->department = 'EI1';
        $user79->phone_number = '12345678910';
        $user79->created_at = Carbon::now();
        $user79->updated_at = null;
        $user79->save();

        $user80 = new User();
        $user80->nik = '31910012';
        $user80->password = '@Fajarpaper123';
        $user80->fullname = 'Herbylian Eka Maulana';
        $user80->department = 'EI1';
        $user80->phone_number = '12345678910';
        $user80->created_at = Carbon::now();
        $user80->updated_at = null;
        $user80->save();

        $user81 = new User();
        $user81->nik = '31911026';
        $user81->password = '@Fajarpaper123';
        $user81->fullname = 'Muhammad Iqbal Azis';
        $user81->department = 'EI1';
        $user81->phone_number = '12345678910';
        $user81->created_at = Carbon::now();
        $user81->updated_at = null;
        $user81->save();

        $user82 = new User();
        $user82->nik = '31911027';
        $user82->password = '@Fajarpaper123';
        $user82->fullname = 'Rizky Octavian Pradana';
        $user82->department = 'EI1';
        $user82->phone_number = '12345678910';
        $user82->created_at = Carbon::now();
        $user82->updated_at = null;
        $user82->save();

        $user83 = new User();
        $user83->nik = '31912016';
        $user83->password = '@Fajarpaper123';
        $user83->fullname = 'Agelikus Parapa';
        $user83->department = 'EI1';
        $user83->phone_number = '12345678910';
        $user83->created_at = Carbon::now();
        $user83->updated_at = null;
        $user83->save();

        $user84 = new User();
        $user84->nik = '32007012';
        $user84->password = '@Fajarpaper123';
        $user84->fullname = 'Ridwan Abdurahman';
        $user84->department = 'EI1';
        $user84->phone_number = '12345678910';
        $user84->created_at = Carbon::now();
        $user84->updated_at = null;
        $user84->save();

        $user85 = new User();
        $user85->nik = '32011003';
        $user85->password = '@Fajarpaper123';
        $user85->fullname = 'Tedy Nurdiansyah';
        $user85->department = 'EI1';
        $user85->phone_number = '12345678910';
        $user85->created_at = Carbon::now();
        $user85->updated_at = null;
        $user85->save();

        $user86 = new User();
        $user86->nik = '32100017';
        $user86->password = '@Fajarpaper123';
        $user86->fullname = 'Udi Samyono';
        $user86->department = 'EI1';
        $user86->phone_number = '12345678910';
        $user86->created_at = Carbon::now();
        $user86->updated_at = null;
        $user86->save();

        $user87 = new User();
        $user87->nik = '32100027';
        $user87->password = '@Fajarpaper123';
        $user87->fullname = 'Kusmantoro';
        $user87->department = 'EI1';
        $user87->phone_number = '12345678910';
        $user87->created_at = Carbon::now();
        $user87->updated_at = null;
        $user87->save();

        $user88 = new User();
        $user88->nik = '33000146';
        $user88->password = '@Fajarpaper123';
        $user88->fullname = 'Sujana';
        $user88->department = 'EI1';
        $user88->phone_number = '12345678910';
        $user88->created_at = Carbon::now();
        $user88->updated_at = null;
        $user88->save();

        $user89 = new User();
        $user89->nik = '33000180';
        $user89->password = '@Fajarpaper123';
        $user89->fullname = 'Rangga Pratama';
        $user89->department = 'EI1';
        $user89->phone_number = '12345678910';
        $user89->created_at = Carbon::now();
        $user89->updated_at = null;
        $user89->save();

        $user90 = new User();
        $user90->nik = '33000181';
        $user90->password = '@Fajarpaper123';
        $user90->fullname = 'Shuhuf Kholisdianto';
        $user90->department = 'EI1';
        $user90->phone_number = '12345678910';
        $user90->created_at = Carbon::now();
        $user90->updated_at = null;
        $user90->save();

        $user91 = new User();
        $user91->nik = '33000183';
        $user91->password = '@Fajarpaper123';
        $user91->fullname = 'Romi Maryurisben';
        $user91->department = 'EI1';
        $user91->phone_number = '12345678910';
        $user91->created_at = Carbon::now();
        $user91->updated_at = null;
        $user91->save();

        $user92 = new User();
        $user92->nik = '33000185';
        $user92->password = '@Fajarpaper123';
        $user92->fullname = 'Fransiscus Intan Prakoso';
        $user92->department = 'EI1';
        $user92->phone_number = '12345678910';
        $user92->created_at = Carbon::now();
        $user92->updated_at = null;
        $user92->save();

        $user93 = new User();
        $user93->nik = '33000202';
        $user93->password = '@Fajarpaper123';
        $user93->fullname = 'Budi Utomo';
        $user93->department = 'EI1';
        $user93->phone_number = '12345678910';
        $user93->created_at = Carbon::now();
        $user93->updated_at = null;
        $user93->save();

        $user94 = new User();
        $user94->nik = '33000203';
        $user94->password = '@Fajarpaper123';
        $user94->fullname = 'Ilham Pribadi';
        $user94->department = 'EI1';
        $user94->phone_number = '12345678910';
        $user94->created_at = Carbon::now();
        $user94->updated_at = null;
        $user94->save();

        $user95 = new User();
        $user95->nik = '33000204';
        $user95->password = '@Fajarpaper123';
        $user95->fullname = 'Supriyatno';
        $user95->department = 'EI1';
        $user95->phone_number = '12345678910';
        $user95->created_at = Carbon::now();
        $user95->updated_at = null;
        $user95->save();

        $user96 = new User();
        $user96->nik = '33000205';
        $user96->password = '@Fajarpaper123';
        $user96->fullname = 'Muhammad Rafi';
        $user96->department = 'EI1';
        $user96->phone_number = '12345678910';
        $user96->created_at = Carbon::now();
        $user96->updated_at = null;
        $user96->save();

        $user97 = new User();
        $user97->nik = '35200119';
        $user97->password = '@Fajarpaper123';
        $user97->fullname = 'Miftahul Huda';
        $user97->department = 'EI1';
        $user97->phone_number = '12345678910';
        $user97->created_at = Carbon::now();
        $user97->updated_at = null;
        $user97->save();

        $user98 = new User();
        $user98->nik = '46200060';
        $user98->password = '@Fajarpaper123';
        $user98->fullname = 'Adih S.';
        $user98->department = 'EI1';
        $user98->phone_number = '12345678910';
        $user98->created_at = Carbon::now();
        $user98->updated_at = null;
        $user98->save();

        $user99 = new User();
        $user99->nik = '47100140';
        $user99->password = '@Fajarpaper123';
        $user99->fullname = 'Wagi';
        $user99->department = 'EI1';
        $user99->phone_number = '12345678910';
        $user99->created_at = Carbon::now();
        $user99->updated_at = null;
        $user99->save();

        $user100 = new User();
        $user100->nik = '55000002';
        $user100->password = '@Fajarpaper123';
        $user100->fullname = 'Abas';
        $user100->department = 'EI1';
        $user100->phone_number = '12345678910';
        $user100->created_at = Carbon::now();
        $user100->updated_at = null;
        $user100->save();

        $user101 = new User();
        $user101->nik = '55000066';
        $user101->password = '@Fajarpaper123';
        $user101->fullname = 'Whisnu Eko Prabowo';
        $user101->department = 'EI1';
        $user101->phone_number = '12345678910';
        $user101->created_at = Carbon::now();
        $user101->updated_at = null;
        $user101->save();

        $user102 = new User();
        $user102->nik = '55000071';
        $user102->password = '@Fajarpaper123';
        $user102->fullname = 'Erry Puji Anggoro';
        $user102->department = 'EI1';
        $user102->phone_number = '12345678910';
        $user102->created_at = Carbon::now();
        $user102->updated_at = null;
        $user102->save();

        $user103 = new User();
        $user103->nik = '55000075';
        $user103->password = '@Fajarpaper123';
        $user103->fullname = 'A. Luqmanul Hakim';
        $user103->department = 'EI1';
        $user103->phone_number = '12345678910';
        $user103->created_at = Carbon::now();
        $user103->updated_at = null;
        $user103->save();

        $user104 = new User();
        $user104->nik = '55000079';
        $user104->password = '@Fajarpaper123';
        $user104->fullname = 'Beni Juliana Maulana';
        $user104->department = 'EI1';
        $user104->phone_number = '12345678910';
        $user104->created_at = Carbon::now();
        $user104->updated_at = null;
        $user104->save();

        $user105 = new User();
        $user105->nik = '55000092';
        $user105->password = '@Fajarpaper123';
        $user105->fullname = 'R.much. Arief Syarifuddin';
        $user105->department = 'EI1';
        $user105->phone_number = '12345678910';
        $user105->created_at = Carbon::now();
        $user105->updated_at = null;
        $user105->save();

        $user106 = new User();
        $user106->nik = '55000093';
        $user106->password = '@Fajarpaper123';
        $user106->fullname = 'Saiful Bahri';
        $user106->department = 'EI1';
        $user106->phone_number = '12345678910';
        $user106->created_at = Carbon::now();
        $user106->updated_at = null;
        $user106->save();

        $user107 = new User();
        $user107->nik = '55000108';
        $user107->password = '@Fajarpaper123';
        $user107->fullname = 'Edi Dwitanto';
        $user107->department = 'EI1';
        $user107->phone_number = '12345678910';
        $user107->created_at = Carbon::now();
        $user107->updated_at = null;
        $user107->save();

        $user108 = new User();
        $user108->nik = '55000120';
        $user108->password = '@Fajarpaper123';
        $user108->fullname = 'Frengky Raja Hamonangan';
        $user108->department = 'EI1';
        $user108->phone_number = '12345678910';
        $user108->created_at = Carbon::now();
        $user108->updated_at = null;
        $user108->save();

        $user109 = new User();
        $user109->nik = '55000125';
        $user109->password = '@Fajarpaper123';
        $user109->fullname = 'Arief Rahman';
        $user109->department = 'EI1';
        $user109->phone_number = '12345678910';
        $user109->created_at = Carbon::now();
        $user109->updated_at = null;
        $user109->save();

        $user110 = new User();
        $user110->nik = '55000129';
        $user110->password = '@Fajarpaper123';
        $user110->fullname = 'Jodi Prastowo';
        $user110->department = 'EI1';
        $user110->phone_number = '12345678910';
        $user110->created_at = Carbon::now();
        $user110->updated_at = null;
        $user110->save();

        $user111 = new User();
        $user111->nik = '55000130';
        $user111->password = '@Fajarpaper123';
        $user111->fullname = 'Luki Tri Rachman';
        $user111->department = 'EI1';
        $user111->phone_number = '12345678910';
        $user111->created_at = Carbon::now();
        $user111->updated_at = null;
        $user111->save();

        $user112 = new User();
        $user112->nik = '55000131';
        $user112->password = '@Fajarpaper123';
        $user112->fullname = 'Abdul Manan';
        $user112->department = 'EI1';
        $user112->phone_number = '12345678910';
        $user112->created_at = Carbon::now();
        $user112->updated_at = null;
        $user112->save();

        $user113 = new User();
        $user113->nik = '55000133';
        $user113->password = '@Fajarpaper123';
        $user113->fullname = 'Gilang Irawan';
        $user113->department = 'EI1';
        $user113->phone_number = '12345678910';
        $user113->created_at = Carbon::now();
        $user113->updated_at = null;
        $user113->save();

        $user114 = new User();
        $user114->nik = '55000135';
        $user114->password = '@Fajarpaper123';
        $user114->fullname = 'Edi Supriadi';
        $user114->department = 'EI1';
        $user114->phone_number = '12345678910';
        $user114->created_at = Carbon::now();
        $user114->updated_at = null;
        $user114->save();

        $user115 = new User();
        $user115->nik = '55000136';
        $user115->password = '@Fajarpaper123';
        $user115->fullname = 'Jaelani';
        $user115->department = 'EI1';
        $user115->phone_number = '12345678910';
        $user115->created_at = Carbon::now();
        $user115->updated_at = null;
        $user115->save();

        $user116 = new User();
        $user116->nik = '55000137';
        $user116->password = '@Fajarpaper123';
        $user116->fullname = 'Ario Gutomo';
        $user116->department = 'EI1';
        $user116->phone_number = '12345678910';
        $user116->created_at = Carbon::now();
        $user116->updated_at = null;
        $user116->save();

        $user117 = new User();
        $user117->nik = '55000147';
        $user117->password = '@Fajarpaper123';
        $user117->fullname = 'Erwin Priono';
        $user117->department = 'EI1';
        $user117->phone_number = '12345678910';
        $user117->created_at = Carbon::now();
        $user117->updated_at = null;
        $user117->save();

        $user118 = new User();
        $user118->nik = '55000148';
        $user118->password = '@Fajarpaper123';
        $user118->fullname = 'Tri Eko Setyawan';
        $user118->department = 'EI1';
        $user118->phone_number = '12345678910';
        $user118->created_at = Carbon::now();
        $user118->updated_at = null;
        $user118->save();

        $user119 = new User();
        $user119->nik = '55000149';
        $user119->password = '@Fajarpaper123';
        $user119->fullname = 'Andriyanto';
        $user119->department = 'EI1';
        $user119->phone_number = '12345678910';
        $user119->created_at = Carbon::now();
        $user119->updated_at = null;
        $user119->save();

        $user120 = new User();
        $user120->nik = '55000150';
        $user120->password = '@Fajarpaper123';
        $user120->fullname = 'Nurman Cahyadi Putra';
        $user120->department = 'EI1';
        $user120->phone_number = '12345678910';
        $user120->created_at = Carbon::now();
        $user120->updated_at = null;
        $user120->save();

        $user121 = new User();
        $user121->nik = '55000153';
        $user121->password = '@Fajarpaper123';
        $user121->fullname = 'Jamal Mirdad';
        $user121->department = 'EI1';
        $user121->phone_number = '12345678910';
        $user121->created_at = Carbon::now();
        $user121->updated_at = null;
        $user121->save();

        $this->call([
            RoleSeeder::class
        ]);
    }
}
