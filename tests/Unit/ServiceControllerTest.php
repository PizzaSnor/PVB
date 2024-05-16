<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Car;
use App\Models\PlannedService;
use GuzzleHttp\Client;
use App\Models\SiteInfo;
use GuzzleHttp\Psr7\Response;

class ServiceControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function testAutoKunnenAanmelden()
    {
        $user = User::factory()->create(['role_id' => 3]);

        $carData = Car::factory()->raw([
            'user_id' => $user->id,
            'licence_plate' => '15KZH4',
            'brand' => 'TESLA',
            'model' => 'TESLA ROADSTER',
            'power' => '200',
            'odometer' => 50000,
            'fuel_type' => 'Elektriciteit',
            'doors' => '2',
            'seats' => '2',
            'apk_end_date' => '2024-06-26T00:00:00.000',
            'color' => 'WIT',
            'year' => '20100304',
            'body' => 'cabriolet',
            'fuel_efficiency' => '7.32',
            'cc' => 'N/A',
            'weight' => '1235',
            'tax' => 'N/A',
            'service_date' => now()->addDays(2)->format('Y-m-d'),

        ]);

        $response = $this->actingAs($user)->post(route('service.create'), $carData);

        $response->assertRedirect(route('home'));

        $car = Car::where('licence_plate', '15KZH4')->first();
        $this->assertNotNull($car);
    }

    public function testKanAlleenAutoAanmeldenOpBeschikbareDatum()
    {
        // Maak een gebruiker aan
        $user = User::factory()->create(['role_id' => 3]);

        $carData = Car::factory()->create([
            'user_id' => $user->id,
            'licence_plate' => '15KZH4',
        ]);

        $maxCarsPerDay = SiteInfo::first()->max_cars_per_day;
        $plannedServiceCountBeforeMaxPerDay = PlannedService::count() + $maxCarsPerDay;

        PlannedService::factory($maxCarsPerDay)->create([
            'service_date' => '2025-05-18',
            'completed' => '0',
            'car_id' => $carData->id,
        ]);

        $response = $this->actingAs($user)->post(route('service.create'), $carData->toArray());

        $this->assertEquals($plannedServiceCountBeforeMaxPerDay, PlannedService::count());
    }
}
