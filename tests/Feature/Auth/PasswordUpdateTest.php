<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordUpdateTest extends TestCase
{
    protected $createdUsers = [];

    protected function tearDown(): void
    {
        foreach ($this->createdUsers as $user) {
            $user->delete();
        }

        parent::tearDown();
    }

    public function test_wachtwoord_kan_worden_aangepast(): void
    {
        $user = User::factory()->create();
        $this->createdUsers[] = $user;

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    public function test_correct_wachtwoord_vereist_om_wachtwoord_aan_te_passen(): void
    {
        $user = User::factory()->create();
        $this->createdUsers[] = $user;

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('updatePassword', 'current_password')
            ->assertRedirect('/profile');
    }
}
