<?php

namespace Database\Factories;

use App\Models\Check;
use Illuminate\Database\Eloquent\Factories\Factory;

class CheckFactory extends Factory
{
    protected $model = Check::class;

    public function definition()
    {
        return [
            'url_id' => $this->faker->numberBetween(0, 100),
            'status_code' => $this->faker->numberBetween(0, 600),
            'h1' => $this->faker->sentence(5),
            'keywords' => $this->faker->word(),
            'description' => $this->faker->text(),
        ];
    }
}
