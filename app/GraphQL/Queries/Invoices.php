<?php

namespace App\GraphQL\Queries;

use App\Company;
use Carbon\Carbon;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Stripe\Invoice;

class Invoices
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $company = Company::query()->select('id', 'stripe_id')->find($args['id']);

        $invoices = [];
        if ($company && $company->stripe_id) {
            $data = Invoice::all(['limit' => 3, 'customer' => $company->stripe_id]);

            foreach ($data as $value) {
                $invoices[] = [
                    'id'        => $value->id,
                    'amount'    => round($value->amount_paid / 100, 2),
                    'date'      => Carbon::parse($value->created),
                ];
            }
        }

        return $invoices;
    }
}
