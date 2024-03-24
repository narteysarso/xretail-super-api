<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->insert([
            [
                'id' => 'eaee0a9a-6a00-4b8d-acd2-603a4477e004',
                'name' => 'admin',
                'created_at' => new DateTime('now'), 
                'updated_at' => new DateTime('now')
            ],
            [
                'id' => '0126cd1a-7cd9-4643-849f-4798a44bb82a',
                'name' => 'vendor',
                'created_at' => new DateTime('now'), 
                'updated_at' => new DateTime('now')
            ],
            [
                'id' => '6e3c1560-9c82-498d-8a3b-0de706d203d4',
                'name' => 'clerk',
                'created_at' => new DateTime('now'), 
                'updated_at' => new DateTime('now')
            ]
        ]);
    }
}
