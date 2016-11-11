<?php

use Illuminate\Database\Seeder;

class VersionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('versions')->truncate();
        DB::table('versions')->insert([
            'device' => "android",
            'version_code' => 1,
            'version_name' => "1.0",
            'app_url' => "",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
