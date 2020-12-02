<?php

namespace Tests;

use App\Role;
use App\Services\Installation\AppInstallationService;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use MakesGraphQLRequests;

    public function installApp($mail = 'jose@example.com', $first_name = 'Jose', $last_name = 'Fonseca', $username = 'jfonseca')
    {
        $service = app(AppInstallationService::class);
        $service->installApp([
            'first_name'            => $first_name,
            'last_name'             => $last_name,
            'username'              => $username,
            'email'                 => $mail,
            'password'              => 'secret1234',
            'password_confirmation' => 'secret1234',
        ]);
    }

    public function createClient()
    {
        $client = app(ClientRepository::class)->createPasswordGrantClient(null, 'test', 'http://localhost');

        config()->set('lighthouse-graphql-passport.client_id', $client->id);
        config()->set('lighthouse-graphql-passport.client_secret', $client->secret);
    }

    public function createUser($data = [])
    {
        return factory(User::class)->create($data);
    }

    public function signIn($data = [])
    {
        $user = $this->createUser($data);

        Passport::actingAs($user);

        return $user;
    }

    public function assignRole($user, $company, $roleName = Role::ADMIN, $disabled = false)
    {
        $role = Role::where('name', $roleName)->first();

        if (! $role) {
            $role = factory(Role::class)->create(['name' => $roleName]);
        }

        $user->roles()->attach($role->id, [
            'model_id'      => $user->id,
            'model_type'    => User::class,
            'role_id'       => $role->id,
            'company_id'    => $company->id,
            'disabled'      => $disabled,
        ]);

        return $role;
    }
}
