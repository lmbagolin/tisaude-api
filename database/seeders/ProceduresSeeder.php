<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProceduresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $data[] = [
            'name' => 'ELETROCARDIOGRAMA (EEG)',
            'price' => 17.80
        ];
        $data[] = [
            'name' => 'MONITORAMENTO AMBULATORIAL DE PRESSAO ARTERIAL (MAPA)',
            'price' => 161.47
        ];
        $data[] = [
            'name' => 'BIÓPSIA PELE E PARTES MOLES (PELE, TECIDO CELULAR OU GÂNGLIOS SUBCUTÂNEOS, PAREDE ABDOMINAL',
            'price' => 100
        ];
        $data[] = [
            'name' => 'CRIOCIRURGIA',
            'price' => 150
        ];
        $data[] = [
            'name' => 'FISIOTERAPIA GERAL',
            'price' => 80
        ];

        foreach ($data as $insert) {
            $insert['created_at'] = Carbon::now();
            $insert['updated_at'] = Carbon::now();
            DB::table('procedure')->insertGetId($insert);
        }
    }
}
