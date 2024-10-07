<?php

namespace Database\Seeders;

use App\Models\DynamicFiled;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentField extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        DynamicFiled::create([
            'name' => 'summary_required',
            'data' => json_encode(['Diagnosis','Medical Advice','Prescriptions'])
        ]);
        DynamicFiled::create([
            'name' => 'summary_optional',
            'data' => json_encode(['Tests to do','Referral Letter'])
        ]);
        DynamicFiled::create([
            'name' => 'notes_required',
            'data' => json_encode(['Tests to do','Notes Letter'])
        ]);
        DynamicFiled::create([
            'name' => 'notes_optional',
            'data' => json_encode(['Tests to do','Notes Letter'])
        ]);
    }
}
