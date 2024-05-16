<?php

namespace Tests\Unit;

use App\Http\Requests\UpdateTimeRequest;
use App\Models\Day;
use App\Models\SiteInfo;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class ContactTest extends TestCase
{
    private array $createdUsers;

    protected function tearDown(): void
    {
        foreach($this->createdUsers as $user) {
            $user->delete();
        }

        parent::tearDown();
    }

    /**
     * Tests to check that contact information cannot be changed by a user
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_informatie_kan_niet_worden_bewerkt_door_gebruiker(): void
    {
        $user = User::factory()->create([
            'role_id' => 1,
        ]);

        $this->createdUsers[] = $user;

        $content = SiteInfo::firstOrCreate();

        $response = $this
            ->actingAs($user)
            ->put('/dashboard/home/contact', [
                'contact_email' => $content->contact_email,
                'contact_number' => $content->contact_number,
            ]);

        $this->assertAuthenticated();

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');
    }

    /**
     * Tests to check that contact information cna be changed by an admin
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_informatie_kan_worden_bewerkt_door_admin(): void
    {
        $admin = User::factory()->create([
            'role_id' => 3,
        ]);

        $this->createdUsers[] = $admin;

        $content = SiteInfo::firstOrCreate();

        $response = $this
            ->actingAs($admin)
            ->put('/dashboard/home/contact', [
                'contact_email' => $content->contact_email,
                'contact_number' => $content->contact_number,
            ]);

        $this->assertAuthenticated();

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/dashboard/users');
    }

    /**
     * Tests to check that admin can changes store opening times
     *
     * @return void
     */
    public function test_admin_kan_openingstijden_veranderen()
    {
        $admin = User::factory()->create([
            'role_id' => 3,
        ]);

        $this->createdUsers[] = $admin;

        $days = Day::all();

        $formattedDays = collect($days)->map(function ($day) {
            $day->opening_time = Carbon::parse($day->opening_time)->format('H:i');
            $day->closing_time = Carbon::parse($day->closing_time)->format('H:i');

            return $day;
        });

        $response = $this->actingAs($admin)
            ->put(route('dashboard.home.time.update', [
                'days' => $formattedDays->toArray()
            ]));
        $response->assertRedirect(route('dashboard.users.index'));
    }

    /**
     * Tests to check that mechanics cannot change store opening times
     *
     * @return void
     */
    public function test_monteur_kan_openingstijden_niet_veranderen()
    {
        $monteur = User::factory()->create([
            'role_id' => 2,
        ]);

        $this->createdUsers[] = $monteur;

        $days = Day::all();

        $formattedDays = collect($days)->map(function ($day) {
            $day->opening_time = Carbon::parse($day->opening_time)->format('H:i');
            $day->closing_time = Carbon::parse($day->closing_time)->format('H:i');

            return $day;
        });

        $response = $this->actingAs($monteur)
            ->put(route('dashboard.home.time.update', [
                'days' => $formattedDays->toArray()
            ]));
        $response->assertRedirect(route('home'));
    }

    /**
     * Tests to check that users cannot change store opening times
     *
     * @return void
     */
    public function test_gebruiker_kan_openingstijden_niet_veranderen()
    {
        $user = User::factory()->create([
            'role_id' => 2,
        ]);

        $this->createdUsers[] = $user;

        $days = Day::all();

        $formattedDays = collect($days)->map(function ($day) {
            $day->opening_time = Carbon::parse($day->opening_time)->format('H:i');
            $day->closing_time = Carbon::parse($day->closing_time)->format('H:i');

            return $day;
        });

        $response = $this->actingAs($user)
            ->put(route('dashboard.home.time.update', [
                'days' => $formattedDays->toArray()
            ]));
        $response->assertRedirect(route('home'));
    }

    /**
     * Tests to check that the closing time cannot be set before the opening time
     *
     * @return void
     */
    public function test_sluitingstijden_kunnen_niet_voor_de_openingstijden_zijn()
    {
        $admin = User::factory()->create([
            'role_id' => 3,
        ]);

        $this->createdUsers[] = $admin;

        $days = Day::all();

        $formattedDays = collect($days)->map(function ($day) {
            $day->opening_time = Carbon::parse('12:00')->format('H:i');
            $day->closing_time = Carbon::parse('9:00')->format('H:i');

            return $day;
        });

        $response = $this->actingAs($admin)
            ->put(route('dashboard.home.time.update', [
                'days' => $formattedDays->toArray()
            ]));

        $response->assertSessionHasErrors([
            "days.0.closing_time",
            "days.1.closing_time",
            "days.2.closing_time",
            "days.3.closing_time",
            "days.4.closing_time",
            "days.5.closing_time",
            "days.6.closing_time",
        ]);
    }
}
