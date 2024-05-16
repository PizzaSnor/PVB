<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Occasion;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class OccasionControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions;
    public function testApiCall()
    {
        $mockHandler = new MockHandler([
            new Response(200, [], '[
                {
                    "kenteken": "15KZH4",
                    "merk": "TESLA",
                    "handelsbenaming": "TESLA ROADSTER",
                    "eerste_kleur": "WIT",
                    "inrichting": "cabriolet",
                    "aantal_zitplaatsen": "2",
                    "aantal_deuren": "2",
                    "vervaldatum_apk_dt": "2024-06-26T00:00:00.000",
                    "cilinderinhoud": "N/A",
                    "massa_ledig_voertuig": "1235",
                    "bruto_bpm": "N/A",
                    "datum_eerste_toelating": "20100304"
                }
            ]'),
            new Response(200, [], '[{"brandstofverbruik_gecombineerd": "7.32", "brandstof_omschrijving": "Elektrisch"}]')
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $this->app->instance(Client::class, $client);

        $data = [
            'title' => 'Test Occasion',
            'description' => 'Test Description',
            'price' => 15000,
            'licence_plate' => '15KZH4',
            'transmission' => 'Elektrisch',
            'power' => 200,
            'images' => [],
        ];

        $response = $this->post(route('dashboard.occasions.store'), $data);

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testAutoKunnenAanmaken()
    {
        $user = User::factory()->create(['role_id' => 3]);

        $licencePlate = '15KZH4';
        $transmission = 'Semi-automaat';
        $power = 200;
        $title = 'Test Occasion';
        $description = 'Test Description';
        $price = 15000;
        $odometer = 50000;
        $fuelEfficiency = '7.32';
        $fuelType = 'Elektriciteit';

        $occasion = new Occasion();
        $occasion->licence_plate = $licencePlate;
        $occasion->transmission = $transmission;
        $occasion->power = $power;
        $occasion->title = $title;
        $occasion->description = $description;
        $occasion->price = $price;
        $occasion->odometer = $odometer;
        $occasion->sold = false;
        $occasion->sold_date = null;
        $occasion->show_when_sold = false;
        $occasion->brand = 'TESLA';
        $occasion->model = 'TESLA ROADSTER';
        $occasion->color = 'WIT';
        $occasion->year = '20100304';
        $occasion->body = 'cabriolet';
        $occasion->seats = '2';
        $occasion->weight = '1235';
        $occasion->tax = 'N/A';
        $occasion->cc = 'N/A';
        $occasion->doors = '2';
        $occasion->apk_end_date = '2024-06-26T00:00:00.000';
        $occasion->fuel_type = 'Elektriciteit';
        $occasion->fuel_efficiency = '7.32';
        $occasion->save();

        $response = $this->actingAs($user)->post(route('dashboard.occasions.store'), [
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'licence_plate' => $licencePlate,
            'transmission' => $transmission,
            'power' => $power,
            'odometer' => $odometer,
            'fuel_efficiency' => $fuelEfficiency,
            'fuel_type' => $fuelType,
            'images' => [],
        ]);

        $this->assertDatabaseHas('occasions', [
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'licence_plate' => $licencePlate,
            'transmission' => $transmission,
            'power' => $power,
            'odometer' => $odometer,
            'fuel_efficiency' => $fuelEfficiency,
            'fuel_type' => $fuelType,
        ]);

        $occasion = Occasion::where('licence_plate', $licencePlate)->first();
        $this->assertNotNull($occasion);
    }

    public function testAutoMakenMetInformatieUitDeApi()
    {
        $user = User::factory()->create(['role_id' => 3]);

        $apiResponse =
        '[
        {
            "kenteken": "15KZH4",
            "merk": "TESLA",
            "handelsbenaming": "TESLA ROADSTER",
            "eerste_kleur": "WIT",
            "inrichting": "cabriolet",
            "aantal_zitplaatsen": "2",
            "aantal_deuren": "2",
            "vervaldatum_apk_dt": "2024-06-26T00:00:00.000",
            "cilinderinhoud": "N/A",
            "massa_ledig_voertuig": "1235",
            "bruto_bpm": "N/A",
            "datum_eerste_toelating": "20100304"
        }
    ]';

        $fuelApiResponse = '[{"brandstofverbruik_gecombineerd": "7.32", "brandstof_omschrijving": "Elektrisch"}]';

        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                $apiResponse
            ),
            new Response(
                200,
                [],
                $fuelApiResponse
            )
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $this->app->instance(Client::class, $client);

        $licencePlate = '15KZH4';
        $transmission = 'Semi-automaat';
        $power = 200;
        $title = 'Test Occasion';
        $description = 'Test Description';
        $price = 15000;
        $odometer = 50000;

        $occasion = new Occasion();
        $occasion->licence_plate = $licencePlate;
        $occasion->transmission = $transmission;
        $occasion->power = $power;
        $occasion->title = $title;
        $occasion->description = $description;
        $occasion->price = $price;
        $occasion->odometer = $odometer;
        $occasion->sold = false;
        $occasion->sold_date = null;
        $occasion->show_when_sold = false;
        $occasion->brand = 'TESLA';
        $occasion->model = 'TESLA ROADSTER';
        $occasion->color = 'WIT';
        $occasion->year = '20100304';
        $occasion->body = 'cabriolet';
        $occasion->seats = '2';
        $occasion->weight = '1235';
        $occasion->tax = 'N/A';
        $occasion->cc = 'N/A';
        $occasion->doors = '2';
        $occasion->apk_end_date = '2024-06-26T00:00:00.000';
        $occasion->fuel_type = 'Elektriciteit';
        $occasion->fuel_efficiency = '7.32';
        $occasion->save();

        $response = $this->actingAs($user)->post(route('dashboard.occasions.store'), [
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'licence_plate' => $licencePlate,
            'transmission' => $transmission,
            'power' => $power,
            'odometer' => $odometer,
            'images' => [],
        ]);

        $this->assertDatabaseHas('occasions', [
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'licence_plate' => $licencePlate,
            'transmission' => $transmission,
            'power' => $power,
            'odometer' => $odometer,
            'fuel_efficiency' => '7.32',
            'fuel_type' => 'Elektriciteit',
        ]);

        $occasion = Occasion::where('licence_plate', $licencePlate)->first();
        $this->assertNotNull($occasion);
    }
}
