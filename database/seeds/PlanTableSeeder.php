<?php

use Illuminate\Database\Seeder;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->truncate();

        $plans = [
            ['id' => '1', 'name' => 'yearly', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '2', 'name' => 'monthly', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '3', 'name' => 'daily', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '4', 'name' => 'hourly', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '5', 'name' => 'fix expired date', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
        ];

        DB::table('plans')->insert($plans);
    }
}
