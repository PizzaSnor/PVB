<?php

namespace Tests\Unit;

use App\Models\Occasion;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OccasionsFrontendTest extends TestCase
{
    use WithFaker;

    private array $createdOccasions = [];
    protected function tearDown(): void
    {
        foreach($this->createdOccasions as $occasion) {
            $occasion->delete();
        }
        parent::tearDown();
    }
    /**
     * A basic unit test example.
     */
    public function test_juiste_occasions_zijn_zichtbaar_voor_gebruiker(): void
    {
        $occasion1 = Occasion::factory()->create(['sold' => false]);
        $occasion2 = Occasion::factory()->create(['sold' => false]);
        $occasion3 = Occasion::factory()->create(['sold' => true, 'show_when_sold' => false]);


        $this->createdOccasions = [$occasion1, $occasion2, $occasion3];

        $response = $this->get(route('occasions.home'));

        $response->assertStatus(200);

        // $occasion3 zou niet zichtbaar moeten zijn aangezien die verkocht is en show_when_sold false is
        $response->assertViewHas('occasions', function ($occasions) use ($occasion1, $occasion2, $occasion3) {
            return $occasions->contains($occasion1) &&
            $occasions->contains($occasion2) &&
            !$occasions->contains($occasion3);
        });
    }

    public function test_detail_zichtbaar_vanaf_occasion(): void
    {
        $occasion = Occasion::where('sold', false)->first();

        $this->assertNotNull($occasion, 'Geen onverkochte occasions om mee te testen.');

        $response = $this->get(route('occasions.view', ['id' => $occasion->id]));

        $response->assertViewHas('occasion', $occasion);
    }
}
