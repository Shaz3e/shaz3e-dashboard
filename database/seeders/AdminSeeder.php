<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->delete();

        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@shaz3e.com',
                'password' => Hash::make('123456789'),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@shaz3e.com',
                'password' => Hash::make('123456789'),
            ],
        ];

        DB::table('admins')->insert($admins);
    }
}
