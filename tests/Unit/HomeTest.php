<?php

namespace Tests\Unit;

use App\Models\Occasion;
use App\Models\SiteInfo;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use WithFaker;

    private array $createdOccasions = [];
    private array $createdUsers = [];
    protected function tearDown(): void
    {
        foreach($this->createdOccasions as $occasion) {
            $occasion->delete();
        }
        foreach($this->createdUsers as $user) {
            $user->delete();
        }
        parent::tearDown();
    }

    /**
     * Test the occasions data in the index method of the HomeController
     * @return void
     */
    public function test_homepagina_laat_3_occasions_zien(): void
    {
        $occasion1 = Occasion::factory()->create(['sold' => false]);
        $occasion2 = Occasion::factory()->create(['sold' => true, 'show_when_sold' => false]);
        $occasion3 = Occasion::factory()->create(['sold' => false]);
        $occasion4 = Occasion::factory()->create(['sold' => true, 'show_when_sold' => true]);

        $this->createdOccasions = [$occasion1, $occasion2, $occasion3, $occasion4];

        $response = $this->get(route('home'));

        $response->assertStatus(200);

        $response->assertViewHas('occasions', function ($occasions) use ($occasion1, $occasion4, $occasion3) {
            $this->assertCount(3, $occasions);
            return $occasions->contains($occasion1) &&
                $occasions->contains($occasion4) &&
                $occasions->contains($occasion3);
        });
    }

    /**
     * Test the site info data in the index method of the HomeController
     *
     * @returns void
     */
    public function test_algemene_informatie_is_te_zien_op_homepage(): void
    {
        $siteInfo = SiteInfo::firstOrCreate([]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);

        $response->assertViewHas('info', function ($info) use ($siteInfo) {
            return $info->main_content === $siteInfo->main_content;
        });
    }

    /**
     * Tests to check that site information cannot be changed by a user and gets redirected
     *
     * @return void
     * @throws \JsonException
     */
    public function  test_algemene_informatie_kan_niet_worden_bewerkt_door_gebruiker(): void
    {
        $user = User::factory()->create([
            'role_id' => 2,
        ]);

        $this->createdUsers[] = $user;

        $content = SiteInfo::firstOrCreate();

        $response = $this
            ->actingAs($user)
            ->put('/dashboard/home/general', [
                'main_content' => $content->main_content,
                'max_cars_per_day' => $content->max_cars_per_day
            ]);

        $this->assertAuthenticated();

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('home'));
    }


    /**
     * Test that site info can be changed by an admin
     *
     * @return void
     * @throws \JsonException
     */
    public function test_algemene_informatie_kan_worden_bewerkt_door_admin(): void
    {
        $admin = User::factory()->create([
            'role_id' => 3,
        ]);

        $this->createdUsers[] = $admin;

        $content = SiteInfo::firstOrCreate();

        $response = $this
            ->actingAs($admin)
            ->put('/dashboard/home/general', [
                'main_content' => $content->main_content,
                'max_cars_per_day' => $content->max_cars_per_day
            ]);

        $this->assertAuthenticated();

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard.users.index'));
    }

}
