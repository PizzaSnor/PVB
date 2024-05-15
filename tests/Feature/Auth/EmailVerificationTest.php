<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    protected $createdUsers = [];

    protected function tearDown(): void
    {
        foreach ($this->createdUsers as $user) {
            $user->delete();
        }

        parent::tearDown();
    }

    public function test_email_verificatie_scherm_kan_worden_weergegeven(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);
        $this->createdUsers[] = $user;

        $response = $this->actingAs($user)->get('/verify-email');

        $response->assertStatus(200);
    }

    public function test_email_wordt_niet_geverifieerd_met_ongeldige_hash(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->createdUsers[] = $user;

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }
}
