<?php

namespace App\Services\Installation;

use App\Permission;
use App\Role;
use App\Services\Installation\Events\ApplicationWasInstalled;
use App\User;
use Closure;
use Illuminate\Validation\ValidationException;

/**
 * Class InstallAppHandler.
 */
class InstallAppHandler
{
    /**
     * @var array|\Illuminate\Support\Collection
     */
    public $roles = [
        ['name' => 'Super Administrator'],
        ['name' => 'Administrator'],
        ['name' => 'User'],
    ];

    /**
     * @var array|\Illuminate\Support\Collection
     */
    public $permissions = [
        'users' => [
            ['name' => 'List users'],
            ['name' => 'Create users'],
            ['name' => 'Delete users'],
            ['name' => 'Update users'],
        ],
        'roles' => [
            ['name' => 'List roles'],
            ['name' => 'Create roles'],
            ['name' => 'Delete roles'],
            ['name' => 'Update roles'],
        ],
        'permissions' => [
            ['name' => 'List permissions'],
        ],
    ];

    /**
     * @var
     */
    public $adminUser;

    /**
     * InstallAppHandler constructor.
     */
    public function __construct()
    {
        $this->roles = collect($this->roles);
        $this->permissions = collect($this->permissions);
    }

    public function handle($installationData, Closure $next)
    {
        $this->createRoles()
            ->createPermissions()
            ->createAdminUser((array) $installationData)
            ->assignAdminRoleToAdminUser()
            ->assignAllPermissionsToAdminRole();
        event(new ApplicationWasInstalled($this->adminUser, $this->roles, $this->permissions));

        return $next($installationData);
    }

    /**
     * @return $this
     */
    public function createRoles()
    {
        $this->roles = $this->roles->map(function ($role) {
            return Role::create($role);
        });

        return $this;
    }

    /**
     * @return $this
     */
    public function createPermissions()
    {
        $this->permissions = $this->permissions->map(function ($group) {
            return collect($group)->map(function ($permission) {
                return Permission::create($permission);
            });
        });

        return $this;
    }

    /**
     * @throws ValidationException
     *
     * @return $this
     */
    public function createAdminUser(array $attributes = [])
    {
        $validator = validator($attributes, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'username' => ['required'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->adminUser = User::create([
            'name' => $attributes['first_name'].' '.$attributes['last_name'],
            'username' => $attributes['username'],
            'email' => $attributes['email'],
            'password' => bcrypt($attributes['password']),
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function assignAdminRoleToAdminUser()
    {
        $this->adminUser->assignRole('Super Administrator');

        return $this;
    }

    /**
     * @return $this
     */
    public function assignAllPermissionsToAdminRole()
    {
        $role = Role::where('name', 'Super Administrator')->firstOrFail();

        $this->permissions->flatten()->each(function ($permission) use ($role) {
            $role->givePermissionTo($permission);
        });

        return $this;
    }
}
