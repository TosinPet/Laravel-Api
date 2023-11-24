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
<<<<<<< Updated upstream
                "full_name" => 'admin test',
                "email" => 'admin@test.com',
                'phone' => "08108220998",
=======
                "full_name" => 'Dev Akeem',
                "email" => 'akeem@dev.com',
                'phone' => "09065764742",
>>>>>>> Stashed changes
                "admin" => "1",
                "account" => "5",
                "suspend" => "0",
                "active" => "1",
                "password" => $password,
<<<<<<< Updated upstream
                "reference_no" => "ref0003"
            ], 
=======
                "reference_no" => "ref0002"
            ],
>>>>>>> Stashed changes
        ]);

    }
}
