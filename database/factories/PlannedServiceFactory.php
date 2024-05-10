<?php

namespace Database\Factories;

use App\Models\PlannedService;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlannedServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PlannedService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'completed' => $this->faker->boolean,
            'service_date' => $this->faker->dateTimeBetween('now', '+30 days'),
            'description' => $this->faker->sentence,
            // Add other fields here
        ];
    }
}
