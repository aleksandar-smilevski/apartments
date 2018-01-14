<?php

use Illuminate\Database\Seeder;
use DeepCopy\TypeFilter\Date;
class ReservationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 0; $i < 8; $i++){

            $from = $faker->date;
            $to = $faker-> date;

            DB::table('reservations')->insert([
                'user_id' => $faker->numberBetween($min = 1, $max = 7),
                'apartment_id' => $faker->numberBetween($min = 1, $max = 8),
                'from' =>$from,
                'to' => $to
            ]);
        }
    }
}
