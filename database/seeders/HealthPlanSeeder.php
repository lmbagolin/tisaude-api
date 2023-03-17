<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HealthPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $data[] = 'SulAmérica Saúde';
        $data[] = 'NotreDame Intermédica';
        $data[] = 'Bradesco Saúde';
        $data[] = 'Hapvida';
        $data[] = 'Amil';
        $data[] = 'Unimed';
        $data[] = 'São Cristóvão Saúde';

        foreach ($data as $name) {
            $insert = [];
            $insert['description'] = $name;
            $insert['phone'] = null;
            $insert['created_at'] = Carbon::now();
            $insert['updated_at'] = Carbon::now();

            DB::table('health_plan')->insertGetId($insert);
        }
    }
}
