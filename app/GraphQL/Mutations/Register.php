<?php

namespace App\GraphQL\Mutations;

use App\Interest;
use App\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Auth\Events\Registered;
use Joselfonseca\LighthouseGraphQLPassport\GraphQL\Mutations\BaseAuthResolver;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Register extends BaseAuthResolver
{
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $data = collect($args)->except('password_confirmation')->toArray();
        $data['password'] = bcrypt($data['password']);
        $data['country_id'] = $data['country'] ?? null;
        $data['state_id'] = $data['state'] ?? null;

        $user = User::create($data);

        foreach ($args['interests'] as $interest) {
            $user->interests()->create([
                'name'  => $interest,
            ]);
        }

        $credentials = $this->buildCredentials([
            'username' => $args[config('lighthouse-graphql-passport.username')],
            'password' => $args['password'],
        ]);

        $user = $user->where(config('lighthouse-graphql-passport.username'), $args[config('lighthouse-graphql-passport.username')])->first();
        $response = $this->makeRequest($credentials);
        $response['user'] = $user;
        event(new Registered($user));

        return [
            'tokens' => $response,
            'status' => 'SUCCESS',
        ];
    }
}
