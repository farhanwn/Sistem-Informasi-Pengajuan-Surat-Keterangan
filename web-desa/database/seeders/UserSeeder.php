<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'NIK' => 320289299242,
                'name' => 'Wiratama',
                'username' => 'wira',
                'email' => 'wiratama@gmail.com',
                'password' => bcrypt('user123')
            ],
            [
                'NIK' => 2123232323,
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123')
            ],
        ]);
    }
}
