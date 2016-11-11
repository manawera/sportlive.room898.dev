<?php

use Illuminate\Database\Seeder;

class GenreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->truncate();

        $genres = [
            ['id' => '1', 'name' => 'inter', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '2', 'name' => 'thai', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '3', 'name' => 'korea', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '4', 'name' => 'japan', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '5', 'name' => 'china', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '6', 'name' => 'asian', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '7', 'name' => 'animation', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
        ];

        DB::table('genres')->insert($genres);
    }
}
