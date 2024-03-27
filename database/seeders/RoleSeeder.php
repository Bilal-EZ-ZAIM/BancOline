<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['titre' => 'admin'],
            ['titre' => 'client'],
            ['titre' => 'employee'],
        ];

        DB::table('roles')->insert($roles);
    }
}
