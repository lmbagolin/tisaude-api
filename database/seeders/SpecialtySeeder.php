<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $data[] = 'Psiquiatra';
        $data[] = 'Pediatra';
        $data[] = 'Geriatra';
        $data[] = 'Psicólogo';
        $data[] = 'Cardiologista';
        $data[] = 'Urologista';
        $data[] = 'Nutricionista';
        $data[] = 'Oncologista';
        $data[] = 'Alergista';
        $data[] = 'Ortopedista';
        $data[] = 'Fonoaudiólogo';
        $data[] = 'Endocrinologista';
        $data[] = 'Anestesista';
        $data[] = 'Nutrólogo';
        $data[] = 'Hematologista';
        $data[] = 'Osteopata';
        $data[] = 'Nutrólogo';
        $data[] = 'Clínico Geral';
        $data[] = 'Obstetra';
        $data[] = 'Radiologista';

        foreach ($data as $name) {
            $insert = [];
            $insert['name'] = $name;
            $insert['created_at'] = Carbon::now();
            $insert['updated_at'] = Carbon::now();

            DB::table('specialty')->insertGetId($insert);
        }
    }
}
