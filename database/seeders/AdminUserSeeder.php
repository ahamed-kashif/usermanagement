<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Forhad Sarkar',
            'email' => 'engforhadsarkar@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Dev',
            'email' => 'sahkashif@gmail.com',
            'password' => bcrypt('021031KfS'),
            'role' => 'admin'
        ]);

    }
}
