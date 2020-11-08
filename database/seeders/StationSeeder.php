<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Cairo'],
            ['name' => 'Giza'],
            ['name' => 'AlFayyum'],
            ['name' => 'AlMinya'],
            ['name' => 'Asyut'],
        ];

        Station::insert($data);
    }
}
