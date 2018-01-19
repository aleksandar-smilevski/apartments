<?php

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i = 0; $i < 20; $i++){
            DB::table('reviews')->insert([
                'user_id' => $faker->numberBetween($min = 1, $max = 7),
                'apartment_id' => $faker->numberBetween($min = 1, $max = 8),
                'review' => $faker->paragraph(),

            ]);
        }
    }
}
