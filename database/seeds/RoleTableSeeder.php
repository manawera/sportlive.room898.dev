<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();

        $roles = [
            ['id' => '1', 'name' => 'system admin', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '2', 'name' => 'administrator', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '3', 'name' => 'moderator', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '4', 'name' => 'uploader', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '5', 'name' => 'subscriber', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '6', 'name' => 'agent', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '7', 'name' => 'dealer', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '8', 'name' => 'subdealer', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '9', 'name' => 'merchant', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
        ];

        DB::table('roles')->insert($roles);
    }
}
