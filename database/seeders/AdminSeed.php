<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->first_name = "Admin";
        $user->email = "admin@deluxhospital.com";
        $user->password = Hash::make("admin@123");
        $user->save();
        $user->assignRole('admin');
    }
}
