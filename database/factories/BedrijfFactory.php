<?php

namespace Database\Factories;

use App\Models\Bedrijf;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BedrijfFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bedrijf::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'naam' => $this->faker->company,
            'custom_url' => Str::slug($this->faker->company), // Generate a URL-friendly version of the company name
            'user_id' => \App\Models\User::factory(), // Create a related user
        ];
    }
}
