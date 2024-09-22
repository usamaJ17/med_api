<?php

namespace Database\Seeders;

use App\Models\Tweek;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TweekSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tweek::create([
            'type' => 'verification_fee',
            'value' => 50,
        ]);
        Tweek::create([
            'type' => 'emergency_help_fee',
            'value' => 50,
        ]);
        Tweek::create([
            'type' => 'activation_fee',
            'value' => 50,
        ]);
    }
}
