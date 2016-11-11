<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'name' => "SuperAdmin",
            'email' => "superadmin@mail.com",
            'username' => "superadmin",
            'password' => bcrypt('l;ylfu8iy[]'),
            'remember_token' => str_random(10),
            'role_id' => 1,
            'active' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
