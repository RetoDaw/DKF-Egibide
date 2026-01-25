<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamiliaTutorSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {

        DB::table('familia_tutor')->updateOrInsert(
            [
                'familias_profesionales_id' => 1,
                'tutor_id' => 1
            ],
            [
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
}
