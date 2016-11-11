<?php

use Illuminate\Database\Seeder;

class TopupTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('topup_types')->truncate();

        $types = [
            ['id' => '1', 'name' => 'prepaid cards', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '2', 'name' => 'memberships', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '3', 'name' => 'truemoney', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '4', 'name' => 'activate code', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '5', 'name' => 'trial code', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
        ];

        DB::table('topup_types')->insert($types);
    }
}
