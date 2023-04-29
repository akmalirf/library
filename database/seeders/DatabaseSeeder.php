<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

use App\Models\Author;
use App\Models\Book;
use App\Models\Catalog;
use App\Models\Member;
use App\Models\Publisher;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        // \App\Models\User::factory(10)->create();

        for ($i=0; $i <20; $i++) {
            $author = new Author;

            $author->name = $faker->name;
            $author->email = $faker->email;
            $author->phone_number = '0821'.$faker->randomNumber(8);
            $author->address = $faker->address;

            $author->save();
        }

        for ($i=0; $i < 4; $i++) {
            $catalog = new Catalog;

            $catalog->name = $faker->name;
            
            $catalog->save();
        }

        for ($i=0; $i <20; $i++) {
            $member = new Member;

            $member->name = $faker->name;
            $member->gender = $faker->randomElement($array = array ('L','P'));
            $member->email = $faker->email;
            $member->phone_number = '0821'.$faker->randomNumber(8);
            $member->address = $faker->address;

            $member->save();
        }

        for ($i=0; $i < 5; $i++) {
            $publisher = new Publisher;

            $publisher->name = $faker->name;
            $publisher->email = $faker->email;
            $publisher->phone_number = '0821'.$faker->randomNumber(8);
            $publisher->address = $faker->address;
            
            $publisher->save();
        }

        for ($i=0; $i < 20; $i++) {
            $book = new Book;

            $book->isbn = $faker->randomNumber(9);
            $book->title = $faker->name;
            $book->year = rand(2010,2021);

            $book->publisher_id = rand(1,5);
            $book->author_id = rand(1,20);
            $book->catalog_id = rand(1,4);

            $book->qty = rand(10,20);
            $book->price = rand(10000,20000);

            $book->save();
        }
    
    }
}
