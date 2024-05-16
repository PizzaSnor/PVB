<?php

namespace Database\Factories;

use App\Models\Occasion;
use Illuminate\Database\Eloquent\Factories\Factory;

class OccasionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Occasion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sold = $this->faker->boolean;
        $sold_date = $sold ? $this->faker->dateTimeBetween('-4 month', now()) : NULL;
        return [
            'title' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(1000, 20000),
            'licence_plate' => $this->faker->unique()->regexify('[A-Z]{2}-\d{2}-\d{2}'),
            'odometer' => $this->faker->numberBetween(10000, 200000),
            'sold' => $sold,
            'sold_date' => $sold_date, 
            'brand' => $this->faker->word,
            'model' => $this->faker->word,
            'color' => $this->faker->safeColorName,
            'year' => $this->faker->numberBetween(1990, 2022),
            'body' => $this->faker->randomElement(['Sedan', 'Hatchback', 'SUV']),
            'fuel_type' => $this->faker->randomElement(['Benzine', 'Diesel', 'Elektrisch']),
            'transmission' => $this->faker->randomElement(['Schakel', 'Automaat', 'Semi-automaat']),
            'power' => $this->faker->numberBetween(50, 300),
            'doors' => $this->faker->numberBetween(2, 5),
            'seats' => $this->faker->numberBetween(2, 7),
            'apk_end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'fuel_efficiency' => $this->faker->randomFloat(2, 5, 15),
            'cc' => $this->faker->numberBetween(1000, 3000),
            'weight' => $this->faker->numberBetween(1000, 3000),
            'tax' => $this->faker->numberBetween(100, 500),
        ];
    }
}
