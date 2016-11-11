<?php

use Illuminate\Database\Seeder;

class ProtectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('protects')->truncate();

        $protects = [
            ['id' => '1', 'name' => 'none', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '2', 'name' => 'wms wowza live', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '3', 'name' => 'wms wowza vod', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '4', 'name' => 'wms nimble live', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '5', 'name' => 'wms nimble vod', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '6', 'name' => 'totfw', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
        ];

        DB::table('protects')->insert($protects);
    }
}
