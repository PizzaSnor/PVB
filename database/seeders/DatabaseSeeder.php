<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Day;
use App\Models\Occasion;
use App\Models\PlannedService;
use App\Models\Role;
use App\Models\SiteInfo;
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

        $users = User::factory()->count(10)->create();

        Occasion::factory()->count(10)->create();

        $cars = Car::factory()->count(10)->create();

        $cars->each(function ($car) use ($users) {
            $car->user_id = $users->random()->id;
            $car->save();
        });

        $cars->each(function ($car) {
            PlannedService::factory()->create([
                'car_id' => $car->id,
                'service_date' => Carbon::now()->addDays(rand(-5, 5)),
            ]);
        });

        SiteInfo::create([
            'main_content' => 'Niet zo goed in navigeren? Google maps wel! Met deze knop hier onder word je gemakkelijk zo snel mogelijk naar ons toe geleid!',
            'contact_email' => 'Muntinglaan 3',
            'contact_number' => '9727 JT',
            'max_cars_per_day' => 5
        ]);

        for ($i = 0; $i <= 6; $i++) {
            Day::create([
                'weekday' => $i,
                'opening_time' => Carbon::parse('09:00'),
                'closing_time' => Carbon::parse('17:00'),
            ]);
        }

        User::create([
           'email' => 'admin@admin.nl',
           'name' => 'Admin',
           'role_id' => 3,
           'password' => 12345678
        ]);
    }
}
