<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name'=>'admin']);
        Role::create(['name' => 'medical']);
        Role::create(['name' => 'patient']);
        Role::create(['name'=>'manager']);
        Role::create(['name'=>'editor']);
        $user = User::create([
            'last_name'=>'',
            'first_name'=>'admin',
            'email' => 'admin@deluxhospital.com',
            'password' => Hash::make('admin123'),
        ]);
        $user->assignRole('admin');
        $user = User::create([
            'last_name'=>'',
            'first_name'=>'Manager',
            'email' => 'manager@deluxhospital.com',
            'password' => Hash::make('manager123'),
        ]);
        $user->assignRole('manager');
        $user = User::create([
            'last_name'=>'',
            'first_name'=>'editor',
            'email' => 'editor@deluxhospital.com',
            'password' => Hash::make('editor123'),
        ]);
        $user->assignRole('editor');
    }
}
