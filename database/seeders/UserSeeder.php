<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
        //
        $password = Hash::make('123456');
        DB::table('users')->insert([
            [
                "full_name" => 'admin test',
                "email" => 'admin@test.com',
                'phone' => "08108220998",
                "admin" => "1",
                "account" => "5",
                "suspend" => "0",
                "active" => "1",
                "password" => $password,
                "reference_no" => "ref0003"
            ], 
        ]);
    }
}
