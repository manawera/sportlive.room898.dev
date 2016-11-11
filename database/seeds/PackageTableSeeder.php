<?php

use Illuminate\Database\Seeder;

class PackageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('packages')->truncate();

        $packages = [
            ['id' => '1', 'name' => 'normal', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '2', 'name' => 'vip', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '3', 'name' => 'trial', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
        ];

        DB::table('packages')->insert($packages);
    }
}
