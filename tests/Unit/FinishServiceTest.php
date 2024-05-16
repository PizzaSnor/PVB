<?php

namespace Tests\Unit;

use App\Models\Car;
use App\Models\Occasion;
use App\Models\PlannedService;
use App\Models\SiteInfo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FinishServiceTest extends TestCase
{
    use WithFaker;

    private array $createdServices = [];
    private array $createdCars = [];

    private array $createdUsers = [];
    protected function tearDown(): void
    {
        foreach($this->createdServices as $service) {
            $service->delete();
        }

        foreach($this->createdCars as $car) {
            $car->delete();
        }

        foreach($this->createdUsers as $user) {
            $user->delete();
        }

        parent::tearDown();
    }

    /**
     * Test that maintenance can be finished with a small assay by a mechanic
     * @return void
    */
    public function test_service_kan_afgerond_worden_door_monteur_met_verslag(): void
    {
        $user = User::factory()->create([
            'role_id' => 2,
        ]);
        $this->createdUsers[] = $user;

        $car = Car::factory()->create();

        $this->createdCars[] = $car;

        $plannedService = PlannedService::factory()->create([
            'car_id' => $car->id,
            'service_date' => Carbon::now()->addDays(rand(-5, 5)),
        ]);
        $this->createdServices[] = $plannedService;

        $inputData = [
            'description' => 'Test service voltooid.',
        ];

        $this->actingAs($user);

        $response = $this->put(route('dashboard.service.finish', ['car' => $car->id]), $inputData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('planned_service', [
            'id' => $plannedService->id,
            'completed' => true,
            'description' => 'Test service voltooid.',
        ]);

        $response->assertRedirect(route('dashboard.service.index'));
        $response->assertSessionHas('success', 'Servicebeurt succesvol afgerond.');
    }


    /**
     * Test that maintenance can be finished with a small assay by an admin
     *
     * @return void
     */
    public function test_service_kan_afgerond_worden_door_admin_met_verslag(): void
    {
        $user = User::factory()->create([
            'role_id' => 3,
        ]);
        $this->createdUsers[] = $user;

        $car = Car::factory()->create();

        $plannedService = PlannedService::factory()->create([
            'car_id' => $car->id,
            'service_date' => Carbon::now()->addDays(rand(-5, 5)),
        ]);
        $this->createdServices[] = $plannedService;

        $inputData = [
            'description' => 'Test service voltooid.',
        ];

        $this->actingAs($user);

        $response = $this->put(route('dashboard.service.finish', ['car' => $car->id]), $inputData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('planned_service', [
            'id' => $plannedService->id,
            'completed' => true,
            'description' => 'Test service voltooid.',
        ]);

        $response->assertRedirect(route('dashboard.service.index'));
        $response->assertSessionHas('success', 'Servicebeurt succesvol afgerond.');
    }
}
