<?php

namespace Tests\Unit;

use App\Models\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class RoleTest extends TestCase
{
    use DatabaseTransactions;
    public function testKanRolMaken()
    {
        $role = Role::factory()->create(['name' => 'Test Role']);
        $this->assertNotNull($role);
        $this->assertEquals('Test Role', $role->name);
    }

    public function testKanRolAanpassen()
    {
        $role = Role::factory()->create(['name' => 'Test Role']);
        $role->update(['name' => 'Updated Role']);
        $this->assertEquals('Updated Role', $role->fresh()->name);
    }

    public function testKanRolVerwjderen()
    {
        $role = Role::factory()->create(['name' => 'Test Role']);
        $role->delete();
        $this->assertDatabaseMissing('roles', ['name' => 'Test Role']);
    }
}
