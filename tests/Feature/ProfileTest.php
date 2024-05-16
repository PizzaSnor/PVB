<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ProfileTest extends TestCase
{
    use WithFaker;

    protected $createdUsers = [];

    protected function tearDown(): void
    {
        foreach ($this->createdUsers as $user) {
            $user->delete();
        }

        parent::tearDown();
    }

    public function test_profielpagina_is_te_bereiken(): void
    {
        $user = User::factory()->create();
        $this->createdUsers[] = $user;

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profiel_informatie_kan_worden_bewerkt(): void
    {
        $user = User::factory()->create();
        $this->createdUsers[] = $user;

        $newEmail = $this->faker->unique()->safeEmail;

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
            'email' => $newEmail,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame($newEmail, $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_gebruiker_kan_account_verwijderen(): void
    {
        $user = User::factory()->create();
        $this->createdUsers[] = $user;

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_wachtwoord_moet_juist_zijn_om_account_te_verwijderen(): void
    {
        $user = User::factory()->create();
        $this->createdUsers[] = $user;

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
