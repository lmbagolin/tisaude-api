<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $data[] = 'Machado de Assis';
        $data[] = 'Carlos Drummond de Andrade';
        $data[] = 'Cecília Meireles';
        $data[] = 'Guimarães Rosa';
        $data[] = 'Clarice Lispector';
        $data[] = 'William Shakespeare';
        $data[] = 'Manuel Bandeira';
        $data[] = 'Lima Barreto';
        $data[] = 'Jorge Leal Amado de Faria';
        $data[] = 'Graciliano Ramos';
        $data[] = 'Ariano Suassuna';

        $uf = [];
        $uf[] = "AC";
        $uf[] = "AL";
        $uf[] = "AP";
        $uf[] = "AM";
        $uf[] = "BA";
        $uf[] = "CE";
        $uf[] = "ES";
        $uf[] = "GO";
        $uf[] = "MA";
        $uf[] = "MT";
        $uf[] = "MS";
        $uf[] = "MG";
        $uf[] = "PA";
        $uf[] = "PB";
        $uf[] = "PR";
        $uf[] = "PE";
        $uf[] = "PI";
        $uf[] = "RJ";
        $uf[] = "RN";
        $uf[] = "RS";
        $uf[] = "RO";
        $uf[] = "RR";
        $uf[] = "SC";
        $uf[] = "SP";
        $uf[] = "SE";
        $uf[] = "TO";

        foreach ($data as $name) {
            $insert = [];
            $insert['name'] = $name;
            $insert['crm'] = $uf[array_rand($uf)] . "-" . rand(1234, 9876);
            $insert['created_at'] = Carbon::now();
            $insert['updated_at'] = Carbon::now();

            DB::table('doctor')->insertGetId($insert);
        }
    }
}
