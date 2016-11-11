<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(GenreTableSeeder::class);
        $this->call(KindTableSeeder::class);
        $this->call(PackageTableSeeder::class);
        $this->call(PlanTableSeeder::class);
        $this->call(ProtectTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(TopupTypeTableSeeder::class);
        $this->call(TvGenreTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
