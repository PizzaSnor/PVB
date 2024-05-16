<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    protected $createdUsers = [];

    protected function tearDown(): void
    {
        foreach ($this->createdUsers as $user) {
            $user->delete();
        }

        parent::tearDown();
    }

    public function test_gebruikers_kunnen_inloggen_doormiddel_van_het_loginscherm(): void
    {
        $user = User::factory()->create();
        $this->createdUsers[] = $user;

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_gebruikers_kunnen_niet_inloggen_met_een_foutief_wachtwoord(): void
    {
        $user = User::factory()->create();
        $this->createdUsers[] = $user;

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_gebruikers_kunnen_uitloggen(): void
    {
        $user = User::factory()->create();
        $this->createdUsers[] = $user;

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
