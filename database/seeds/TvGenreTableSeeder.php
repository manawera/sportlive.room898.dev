<?php

use Illuminate\Database\Seeder;

class TvGenreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tv_genres')->truncate();

        $tv_genres = [
            ['id' => '1', 'name' => 'Digital TV', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '2', 'name' => 'News', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '3', 'name' => 'Movies & Series', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '4', 'name' => 'Entertainment', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '5', 'name' => 'Kids', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '6', 'name' => 'Documentary', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '7', 'name' => 'Sports', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '8', 'name' => 'Religion', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '9', 'name' => 'Education', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '10', 'name' => 'HD Zone', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
            ['id' => '11', 'name' => 'Adult', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
        ];

        DB::table('tv_genres')->insert($tv_genres);
    }
}
