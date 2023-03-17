<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PacientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $data[] = ['Tom Cruise', '1962-07-03'];
        $data[] = ['Will Smith', '1968-09-25'];
        $data[] = ['Leonardo DiCaprio', '1974-11-11'];
        $data[] = ['Brad Pitt', '1963-12-18'];
        $data[] = ['Angelina Jolie', '1975-06-04'];
        $data[] = ['Sandra Bullock', '1964-07-26'];
        $data[] = ['Meryl Streep', '1949-06-22'];
        $data[] = ['Megan Fox', '1986-05-16'];
        $data[] = ['Julia Roberts', '1967-10-28'];
        $data[] = ['Charlize Theron', '1975-08-07'];


        foreach ($data as $info) {
            $insert = [];
            $insert['name'] = $info[0];
            $insert['birthday'] = $info[1];
            $insert['phones'] = null;
            $insert['created_at'] = Carbon::now();
            $insert['updated_at'] = Carbon::now();

            DB::table('pacient')->insertGetId($insert);
        }
    }
}
