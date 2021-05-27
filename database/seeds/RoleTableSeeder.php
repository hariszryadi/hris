<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'super-admin', 'description' => 'All content view'],
            ['name' => 'admin', 'description' => 'Admin view'],
        ]);
    }
}
