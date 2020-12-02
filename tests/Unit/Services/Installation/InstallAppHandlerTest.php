<?php

namespace Tests\Unit\Services\Installation;

use App\Role;
use App\Services\Installation\InstallAppHandler;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class InstallAppHandlerTest extends TestCase
{
    use RefreshDatabase;

    public function makeHandler()
    {
        return app(InstallAppHandler::class);
    }

    public function test_it_creates_roles()
    {
        $handler = $this->makeHandler();
        $handler->createRoles();
        $this->assertDatabaseHas('roles', [
            'name' => 'Administrator',
        ]);
    }

    public function test_it_creates_permissions()
    {
        $handler = $this->makeHandler();
        $handler->createPermissions();
        $this->assertDatabaseHas('permissions', [
            'name' => 'List users',
        ]);
        $this->assertDatabaseHas('permissions', [
            'name' => 'Delete users',
        ]);
        $this->assertDatabaseHas('permissions', [
            'name' => 'Update roles',
        ]);
        $this->assertDatabaseHas('permissions', [
            'name' => 'List permissions',
        ]);
    }

    public function test_it_creates_admin_user()
    {
        $role = factory(Role::class)->create([
            'name' => 'Simon Montoya',
        ]);
        $handler = $this->makeHandler();

        $user = factory(User::class)->make();

        $handler->createAdminUser([
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'email'         => $user->email,
            'username'      => $user->username,
            'password'      => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $this->assertDatabaseHas('users', [
            'email'         => $user->email,
            'username'      => $user->username,
        ]);

        $user = User::where('email', $user->email)->first();

        $this->assertNotNull($user->id);
    }

    public function test_it_validates_input_for_creating_user()
    {
        $handler = $this->makeHandler();

        try {
            $handler->createAdminUser([
                'name' => 'Simon Montoya',
            ]);
            $this->fail('Validation to create user did not run.');
        } catch (ValidationException $e) {
            $this->assertDatabaseMissing('users', [
                'name' => 'Simon Montoya',
                'email' => 'simon@example.com',
            ]);
        }
    }

    public function test_it_assigns_admin_role_to_admin_user()
    {
        $handler = $this->makeHandler();

        $user = factory(User::class)->make();

        $result = $handler->createRoles()->createAdminUser([
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'username'      => $user->username,
            'email'         => $user->email,
            'password'      => '12345678',
            'password_confirmation' => '12345678',
        ])->assignAdminRoleToAdminUser();

        $this->assertTrue($result->adminUser->hasRole('Super Administrator'));
    }

    public function test_it_assigns_all_permissions_to_admin_role()
    {
        $handler = $this->makeHandler();
        $result = $handler->createRoles()->createPermissions()->assignAllPermissionsToAdminRole();
        $role = $result->roles->first();

        $this->assertTrue($role->hasPermissionTo('List users'));
        $this->assertTrue($role->hasPermissionTo('Delete users'));
        $this->assertTrue($role->hasPermissionTo('List permissions'));
    }
}
