<?php

namespace App\GraphQL\Mutations;

use App\Order;
use App\Traits\ConsumesExternalServices;
use Dnetix\Redirection\PlacetoPay;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CreateOrder
{
    /**
     * Return a value for the field.
     *
     * @param null                                                $rootValue   Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param mixed[]                                             $args        the arguments that were passed into the field
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context     arbitrary data that is shared between all fields of a single query
     * @param \GraphQL\Type\Definition\ResolveInfo                $resolveInfo information about the query itself, such as the execution state, the field name, path to the field from the root, and more
     *
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $reference = time();
        $user = auth()->user();
        $order = Order::create([
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_mobile' => $args['phone'],
            'user_id' => $user->id,
            'status' => 'CREATED',
            'reference' => $reference,
            'total' => $args['total'],
        ]);

        return  $order;
    }
}
