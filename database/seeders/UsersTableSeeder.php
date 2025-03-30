<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Insert 20 dummy users into the database
        foreach (range(3, 20) as $index) {
            DB::table('users')->insert([
                'id' => $index,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'), // You can set a default password
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
