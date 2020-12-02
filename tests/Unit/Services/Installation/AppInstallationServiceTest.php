<?php

namespace Tests\Unit\Services\Installation;

use App\Services\Installation\AppInstallationService;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppInstallationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function makeService()
    {
        return app(AppInstallationService::class);
    }

    public function test_it_installs_the_app()
    {
        $service = $this->makeService();

        $user = factory(User::class)->make();

        $service->installApp([
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'email'         => $user->email,
            'username'      => $user->username,
            'password'      => '123456789',
            'password_confirmation' => '123456789',
        ]);

        $this->assertDatabaseHas('users', [
            'name'    => $user->first_name.' '.$user->last_name,
            'username'      => $user->username,
            'email'         => $user->email,
        ]);

        $user = User::where('email', $user->email)->first();

        $this->assertTrue($user->hasRole('Super Administrator'));
        $this->assertTrue($user->hasPermissionTo('Update roles'));
    }
}
