<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Occasion;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class OccasionControllerTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    public function testApiMockOmAutoViaApiTeMaken()
    {
        $user = User::factory()->create(['role_id' => 3]);

        $mockResponseData = [
            [
                'merk' => 'TESLA',
                'handelsbenaming' => 'TESLA ROADSTER',
            ]
        ];

        $mockResponse = new Response(200, [], json_encode($mockResponseData));

        //yt dotnet
        $mockHandler = new MockHandler([$mockResponse]);
        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $this->app->instance(Client::class, $client);

        $occasionData = [
            'title' => 'Test Occasion',
            'description' => 'Test Description',
            'price' => 15000,
            'licence_plate' => '15KZH4',
            'transmission' => 'Semi-automaat',
            'power' => '200',
            'odometer' => 50000,
            'sold' => false,
            'show_when_sold' => false,
            'fuel_efficiency' => '7.32',
            'fuel_type' => 'Elektriciteit',
            'doors' => '2',
            'seats' => '2',
            'weight' => '1235',
            'apk_end_date' => '2024-06-26T00:00:00.000',
            'color' => 'WIT',
            'year' => '20100304',
            'body' => 'cabriolet',
            'cc' => 'N/A',
            'tax' => 'N/A',
        ];

        $response = $this->actingAs($user)->post(route('dashboard.occasions.store'), $occasionData);

        $response->assertRedirect(route('dashboard.occasions.index'));

        $occasion = Occasion::where('licence_plate', '15KZH4')->first();
        $this->assertNotNull($occasion);
        $this->assertEquals('TESLA', $occasion->brand);
        $this->assertEquals('TESLA ROADSTER', $occasion->model);
    }
    public function testAutoKunnenAanmaken()
    {
        $user = User::factory()->create(['role_id' => 3]);

        $occasionData = Occasion::factory()->raw([
            'brand' => 'TESLA',
            'model' => 'TESLA ROADSTER',
            'title' => 'Test Occasion',
            'description' => 'Test Description',
            'price' => 15000,
            'licence_plate' => '15KZH4',
            'transmission' => 'Semi-automaat',
            'power' => '200',
            'odometer' => 50000,
            'sold' => false,
            'sold_date' => null,
            'show_when_sold' => false,
            'fuel_efficiency' => '7.32',
            'fuel_type' => 'Elektriciteit',
            'doors' => '2',
            'seats' => '2',
            'weight' => '1235',
            'apk_end_date' => '2024-06-26T00:00:00.000',
            'color' => 'WIT',
            'year' => '20100304',
            'body' => 'cabriolet',
            'cc' => 'N/A',
            'tax' => 'N/A',
        ]);

        $response = $this->actingAs($user)->post(route('dashboard.occasions.store'), $occasionData);

        $response->assertRedirect(route('dashboard.occasions.index'));

        $occasion = Occasion::where('licence_plate', '15KZH4')->first();
        $this->assertNotNull($occasion);
    }

    public function testAutoKunnenBewerken()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $occasion = Occasion::factory()->create();

        $occasionData = [
            'brand' => 'TESLA',
            'model' => 'TESLA ROADSTER',
            'title' => 'Veranderde titel',
            'description' => 'Test Description',
            'price' => 15000,
            'licence_plate' => '15KZH4',
            'transmission' => 'Semi-automaat',
            'power' => '200',
            'odometer' => 50000,
            'sold' => false,
            'sold_date' => null,
            'show_when_sold' => false,
            'fuel_efficiency' => '7.32',
            'fuel_type' => 'Elektriciteit',
            'doors' => '2',
            'seats' => '2',
            'weight' => '1235',
            'apk_end_date' => '2024-06-26T00:00:00.000',
            'color' => 'WIT',
            'year' => '20100304',
            'body' => 'cabriolet',
            'cc' => 'N/A',
            'tax' => 'N/A',
        ];

        $response = $this->actingAs($user)->put(route('dashboard.occasions.update', ['occasion' => $occasion->id]), $occasionData);

        $response->assertRedirect(route('dashboard.occasions.index'));

        $occasion = Occasion::where('licence_plate', '15KZH4')->first();

        $this->assertNotNull($occasion);
    }

    public function testAutoKunnenVerkopen()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $occasion = Occasion::factory()->create();

        $response = $this->actingAs($user)->put(route('dashboard.occasions.sell', ['occasion' => $occasion->id]));

        $response->assertRedirect(route('dashboard.occasions.index'));

        $occasion = Occasion::where('id', $occasion->id)->first();

        $this->assertNotNull($occasion->sold_date);
    }

    public function testAutoKunnenVerwijderen()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $occasion = Occasion::factory()->create();

        $response = $this->actingAs($user)->delete(route('dashboard.occasions.destroy', ['occasion' => $occasion->id]));

        $response->assertRedirect(route('dashboard.occasions.index'));

        $occasion = Occasion::where('id', $occasion->id)->first();

        $this->assertNull($occasion);
    }

    public function testGebruikerHeeftGeenToegangTotCreatePagina()
    {
        $gebruiker = User::factory()->create(['role_id' => 1]);

        $response = $this->actingAs($gebruiker)->get(route('dashboard.occasions.create'));
        $response->assertStatus(302);
    }

    public function testMonteurHeeftGeenToegangTotCreatePagina()
    {
        $monteur = User::factory()->create(['role_id' => 2]);

        $response = $this->actingAs($monteur)->get(route('dashboard.occasions.create'));
        $response->assertStatus(302);
    }

    public function testAdminHeeftToegangTotCreatePagina()
    {
        $admin = User::factory()->create(['role_id' => 3]);

        $response = $this->actingAs($admin)->get(route('dashboard.occasions.create'));
        $response->assertSuccessful();
    }

    public function testGebruikerHeeftGeenToegangTotBewerkPagina()
    {
        $gebruiker = User::factory()->create(['role_id' => 1]);
        $occasion = Occasion::factory()->create();

        $response = $this->actingAs($gebruiker)->get(route('dashboard.occasions.edit', ['occasion' => $occasion->id]));
        $response->assertStatus(302);
    }

    public function testMonteurHeeftGeenToegangTotBewerkPagina()
    {
        $monteur = User::factory()->create(['role_id' => 2]);
        $occasion = Occasion::factory()->create();

        $response = $this->actingAs($monteur)->get(route('dashboard.occasions.edit', ['occasion' => $occasion->id]));
        $response->assertStatus(302);
    }

    public function testAdminHeeftToegangTotBewerkPagina()
    {
        $admin = User::factory()->create(['role_id' => 3]);
        $occasion = Occasion::factory()->create();

        $response = $this->actingAs($admin)->get(route('dashboard.occasions.edit', ['occasion' => $occasion->id]));
        $response->assertSuccessful();
    }

    public function testGebruikerKanOccasionNietVerkopen()
    {
        $gebruiker = User::factory()->create(['role_id' => 1]);
        $occasion = Occasion::factory()->create();

        $response = $this->actingAs($gebruiker)->put(route('dashboard.occasions.sell', ['occasion' => $occasion->id]));
        $response->assertStatus(302);
    }

    public function testMonteurKanOccasionVerkopen()
    {
        $monteur = User::factory()->create(['role_id' => 2]);
        $occasion = Occasion::factory()->create();

        $response = $this->actingAs($monteur)->put(route('dashboard.occasions.sell', ['occasion' => $occasion->id]));
        $response->assertStatus(302);
    }

    public function testAdminKanOccasionVerkopen()
    {
        $admin = User::factory()->create(['role_id' => 3]);
        $occasion = Occasion::factory()->create();

        $response = $this->actingAs($admin)->put(route('dashboard.occasions.sell', ['occasion' => $occasion->id]));
        $response->assertRedirect(route('dashboard.occasions.index'));
    }


    public function testGebruikerKanOccasionNietVerwijderen()
    {
        $gebruiker = User::factory()->create(['role_id' => 1]);
        $occasion = Occasion::factory()->create();

        $response = $this->actingAs($gebruiker)->delete(route('dashboard.occasions.destroy', ['occasion' => $occasion->id]));
        $response->assertStatus(302);
    }

    public function testMonteurKanOccasionNietVerwijderen()
    {
        $monteur = User::factory()->create(['role_id' => 2]);
        $occasion = Occasion::factory()->create();

        $response = $this->actingAs($monteur)->delete(route('dashboard.occasions.destroy', ['occasion' => $occasion->id]));
        $response->assertStatus(302);
    }

    public function testAdminKanOccasionVerwijderen()
    {
        $admin = User::factory()->create(['role_id' => 3]);
        $occasion = Occasion::factory()->create();

        $response = $this->actingAs($admin)->delete(route('dashboard.occasions.destroy', ['occasion' => $occasion->id]));
        $response->assertRedirect(route('dashboard.occasions.index'));
    }
}
