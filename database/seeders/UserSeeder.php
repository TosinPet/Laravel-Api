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
                "first_name" => 'admin',
                "last_name" => 'dashboard',
                "email" => 'dashboard@dash.com',
                "admin" => "1",
                "account" => "9",
                "suspend" => "0",
                "active" => "1",
                "password" => $password,
                "reference_no" => "ref0001"
            ], 
        ]);
    }
}
