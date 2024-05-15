<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    protected $createdUsers = [];

    protected function tearDown(): void
    {
        foreach ($this->createdUsers as $user) {
            $user->delete();
        }

        parent::tearDown();
    }

    public function test_wachtwoord_wordt_niet_bevestigd_met_ongeldig_wachtwoord(): void
    {
        $user = User::factory()->create();
        $this->createdUsers[] = $user;

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
