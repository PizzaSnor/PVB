<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Car;
use App\Models\Occasion;
use App\Policies\CarPolicy;
use App\Policies\OccasionPolicy;


class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testGebruikerHeeftGeenToegangTotOverzichtPagina()
    {
        $user = User::factory()->create(['role_id' => 1]);

        $response = $this->actingAs($user)->get(route('dashboard.users.index'));
        $response->assertStatus(302);
    }
    public function testMonteurHeeftGeenToegangTotOverzichtPagina()
    {
        $user = User::factory()->create(['role_id' => 2]);

        $response = $this->actingAs($user)->get(route('dashboard.users.index'));
        $response->assertStatus(302);
    }
    public function testAdminHeeftToegangTotOverzichtPagina()
    {
        $user = User::factory()->create(['role_id' => 3]);

        $response = $this->actingAs($user)->get(route('dashboard.users.index'));
        $response->assertStatus(200);
    }
    public function testGebruikerHeeftGeenToegangTotBewerkPagina()
    {
        $user = User::factory()->create(['role_id' => 1]);

        $response = $this->actingAs($user)->get(route('dashboard.users.edit', ['user' => $user->id]));
        $response->assertStatus(302);
    }
    public function testMonteurHeeftGeenToegangTotBewerkPagina()
    {
        $user = User::factory()->create(['role_id' => 2]);

        $response = $this->actingAs($user)->get(route('dashboard.users.edit', ['user' => $user->id]));
        $response->assertStatus(302);
    }
    public function testAdminHeeftToegangTotBewerkPagina()
    {
        $user = User::factory()->create(['role_id' => 3]);

        $response = $this->actingAs($user)->get(route('dashboard.users.edit', ['user' => $user->id]));
        $response->assertStatus(200);
    }

    public function testGebruikerKanGebruikerNietVerwijderen()
    {
        $user = User::factory()->create(['role_id' => 1]);
        $otherUser = User::factory()->create();


        $response = $this->actingAs($user)->delete(route('dashboard.users.destroy', ['user' => $otherUser->id]));
        $response->assertStatus(302);
    }
    public function testMonteurKanGebruikerNietVerwijderen()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $otherUser = User::factory()->create();


        $response = $this->actingAs($user)->delete(route('dashboard.users.destroy', ['user' => $otherUser->id]));
        $response->assertStatus(302);
    }
    public function testAdminKanGebruikerVerwijderen()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $otherUser = User::factory()->create(['role_id' => 1]);

        $response = $this->actingAs($user)->delete(route('dashboard.users.destroy', ['user' => $otherUser->id]));
        $response->assertStatus(302);

        $this->assertDatabaseMissing('users', ['id' => $otherUser->id]);
    }

    public function testAdminKanRolAanpasssen()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $otherUser = User::factory()->create();

        $newRoleId = 2;

        $requestData = [
            'name' => $otherUser->name,
            'email' => $otherUser->email,
            'role_id' => $newRoleId,
        ];

        $response = $this->put(route('dashboard.users.update', $otherUser), $requestData);

        $response->assertRedirect(route('dashboard.users.index'))
            ->assertSessionHas('success', 'Gebruiker aangepast');

        $this->assertDatabaseHas('users', [
            'id' => $otherUser->id,
            'role_id' => $newRoleId,
        ]);
    }

    public function testAanpassenGebruikersGevens()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $otherUser = User::factory()->create(['role_id' => 2]);

        $newName = 'John Doe';
        $newEmail = 'john@example.com';
        $newRoleId = 3;

        $requestData = [
            'name' => $newName,
            'email' => $newEmail,
            'role_id' => $newRoleId,
        ];

        $response = $this->put(route('dashboard.users.update', $otherUser), $requestData);

        $response->assertRedirect(route('dashboard.users.index'))
            ->assertSessionHas('success', 'Gebruiker aangepast');

        $this->assertDatabaseHas('users', [
            'id' => $otherUser->id,
            'name' => $newName,
            'email' => $newEmail,
            'role_id' => $newRoleId,
        ]);
    }

    public function testJeKuntJezelfGeenLagereRolGeven()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $user->save();

        $this->actingAs($user);

        $requestData = [
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => 1, 
        ];

        $response = $this->put(route('dashboard.users.update', $user), $requestData);

        $response->assertRedirect(route('dashboard.users.index'))
            ->assertSessionHas('error', 'Je kunt jezelf niet degraderen naar een rol met minder rechten.');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'role_id' => 1,
        ]);
    }
}
