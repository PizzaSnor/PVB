<?php

namespace Tests\Unit;

use App\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    private array $createdRoles = [];

    protected function tearDown(): void
    {
        foreach($this->createdRoles as $role) {
            $role->delete();
        }
        parent::tearDown();
    }
    /**
     * A basic unit test example.
     */
    public function test_creeer_nieuwe_rol(): void
    {
        $roleData = [
            'name' => 'Test',
        ];

        $role = Role::create($roleData);

        $this->createdRoles[] = $role;

        $this->assertDatabaseHas('roles', [
            'name' => 'Test',
        ]);
    }
}
