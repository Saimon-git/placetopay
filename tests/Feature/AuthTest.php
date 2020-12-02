<?php

namespace Tests\Feature;

use App\Company;
use App\Invitation;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_profile()
    {
        $user = $this->signIn();

        $response = $this->graphQL('
            query {
                me {
                    id
                }
            }
        ');

        $response->assertJson([
            'data'  => [
                'me' => [
                    'id'        => $user->id,
                ],
            ],
        ]);
    }
}
