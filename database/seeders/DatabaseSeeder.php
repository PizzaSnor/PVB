<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Occasion;
use App\Models\PlannedService;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create roles
        $roles = [
            ['name' => 'Gebruiker'],
            ['name' => 'Monteur'],
            ['name' => 'Admin'],
        ];
        Role::insert($roles);

        // Create users with random roles
        $users = User::factory()->count(10)->create();

        // Create occasions with faker data
        Occasion::factory()->count(10)->create();

        // Create cars with faker data
        $cars = Car::factory()->count(10)->create();

        // Attach random user to each car
        $cars->each(function ($car) use ($users) {
            $car->user_id = $users->random()->id;
            $car->save();
        });

        // Create planned services for each car
        $cars->each(function ($car) {
            PlannedService::factory()->create([
                'car_id' => $car->id,
                'service_date' => Carbon::now()->addDays(rand(-5, 5)),
            ]);
        });
    }
}
