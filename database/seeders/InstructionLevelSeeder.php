<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InstructionLevel;

class InstructionLevelSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
       $instructionLevel =  InstructionLevel::truncate();
    //    $instructionLevel->delete();
        // for ($i = 1; $i < 5; $i++) {
            $data[1]['level'] = 'beginer';
            $data[2]['level'] = 'intermediate';
            $data[3]['level'] = 'advanced';
        
        // }

        InstructionLevel::insert($data);
    }

}
