<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = [

            [
                'nom' => 'amine',
                'prenom' => 'amigo',
                'email' => 'email3@example.com',
                'password' => Hash::make('12345678'),
                'role' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'banta',
                'prenom' => 'taha',
                'email' => 'email4@example.com',
                'password' => Hash::make('12345678'),
                'role' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'zaim',
                'prenom' => 'zahra',
                'email' => 'email5@example.com',
                'password' => Hash::make('12345678'),
                'role' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'ezz',
                'prenom' => 'khadija',
                'email' => 'email6@example.com',
                'password' => Hash::make('12345678'),
                'role' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'hass',
                'prenom' => 'Hassan',
                'email' => 'email7@example.com',
                'password' => Hash::make('12345678'),
                'role' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more users here...
        ];


        DB::table('users')->insert($users);
    }
}
