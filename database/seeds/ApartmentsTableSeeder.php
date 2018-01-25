<?php

use Illuminate\Database\Seeder;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker\Factory::create();

        for($i = 0; $i < 8; $i++){
            DB::table('apartments')->insert([
               'name' => $faker->paragraph(1),
                'description' => $faker->paragraph(2, true),
                'longitude' => (string)$faker->longitude,
                'latitude' => (string)$faker->latitude,
                'price' => (float)$faker->numberBetween($min = 50, $max = 100),
                'user_id' => $faker -> numberBetween($min = 1, $max = 5),
                'address' => $faker->address
            ]);
        }
    }
}
