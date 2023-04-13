<?php

namespace Database\Seeders;

use App\Models\Catalog;
use Faker\Factory as faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = faker::create();

        for ($i=0; $i < 4; $i++) {
            $catalog = new Catalog;

            $catalog->name = $faker->name;
            
            $catalog->save();
        }
    }
}