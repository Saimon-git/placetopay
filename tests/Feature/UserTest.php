<?php

namespace Tests\Feature;

use App\Company;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_users()
    {
        $user = $this->signIn();

        $response = $this->graphQL('
            {
                users(first: 10) {
                    data {
                        id
                    }
                }
            }
        ');

        $response->assertJson([
            'data'  => [
                'users' => [
                    'data'  => [
                        [
                            'id'  => $user->id,
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function test_show_a_user()
    {
        $user = $this->signIn();

        $response = $this->graphQL('
            {
                user(id: '.$user->id.') {
                    id
                }
            }
        ');

        $response->assertJson([
            'data'  => [
                'user' => [
                    'id'  => $user->id,
                ],
            ],
        ]);
    }
}
