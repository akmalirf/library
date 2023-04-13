<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Faker\Factory as faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = faker::create();

        for ($i=0; $i < 10; $i++) {
            $transaction = new Transaction;

            $transaction->member_id = rand(1,20);
            $transaction->date_start = $faker->dateTimeThisMonth();
            $transaction->date_end = $faker->dateTimeThisMonth('+12 days');


            $transaction->save();
        }
    
    }
}
