<?php

namespace Database\Seeders;

use Faker\Generator;
use App\Models\Check;
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
        for ($i = 0; $i <= 100; $i++) {
            $urlData[] = [
                'name' => $this->faker->url(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach ($urlData as $url) {
            DB::table('urls')->insert($url);
        }

        Check::factory()->count(6)->create([
            'url_id' => 1,
        ]);

        Check::factory()->count(3)->create([
            'url_id' => 2,
        ]);
    }
}
