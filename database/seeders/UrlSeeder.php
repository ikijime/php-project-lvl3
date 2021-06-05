<?php

namespace Database\Seeders;

use Faker\Generator;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Container\Container;

class UrlSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 100;  $i++)
        {
            $urlData[] = [
                'name' => $this->faker->url(),
                'response_code' => $this->faker->randomNumber(3),
            ];
        }

        foreach ($urlData as $url) {
            DB::table('urls')->insert($url);
        }
    }
}
