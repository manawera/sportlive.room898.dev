<?php

use Illuminate\Database\Seeder;

class KindTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kinds')->truncate();

        $kinds = [
            ['id' => '1', 'name' => 'movies', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '2', 'name' => 'tv series', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '3', 'name' => 'tv mini series', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '4', 'name' => 'tv show', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '5', 'name' => 'anime series', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '6', 'name' => 'concert', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '7', 'name' => 'adult video', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '8', 'name' => 'episode', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
        ];

        DB::table('kinds')->insert($kinds);
    }
}
