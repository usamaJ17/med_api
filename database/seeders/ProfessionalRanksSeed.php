<?php

namespace Database\Seeders;

use App\Models\Professions;
use App\Models\Ranks;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfessionalRanksSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Professions::create(['name' => 'Physician']);
        Professions::create(['name' => 'Nurse']);
        Ranks::create(['name' => 'Senior']);
        Ranks::create(['name' => 'Junior']);
    }

}
