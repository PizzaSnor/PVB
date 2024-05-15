<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Role;
use App\Models\User;

class RegistrationTest extends TestCase
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

    public function test_gebruiker_kan_registreren(): void
    {
        $role = Role::find(2);

        $response = $this->post('/register', [
            'name' => $this->faker->name,
            'email' => $email = $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
            'role_id' => $role->id, 
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect(RouteServiceProvider::HOME);

        $user = User::where('email', $email)->first();
        $this->createdUsers[] = $user;
    }
}
