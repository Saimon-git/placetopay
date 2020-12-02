<?php

namespace App\GraphQL\Mutations;

use App\Order;
use App\Traits\ConsumesExternalServices;
use Dnetix\Redirection\PlacetoPay;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class PayOrder
{
    protected $baseUri;

    protected $Login;

    protected $TranKey;

    protected $placetopay;

    public function __construct()
    {
        $this->baseUri = config('services.placetopay.base_uri');
        $this->Login = config('services.placetopay.Login');
        $this->TranKey = config('services.placetopay.TranKey');
        $this->placetopay = new PlacetoPay([
            'login' => $this->Login,
            'tranKey' => $this->TranKey,
            'url' => $this->baseUri,
            'rest' => [
                'timeout' => 45, // (optional) 15 by default
                'connect_timeout' => 30, // (optional) 5 by default
            ],
        ]);
    }

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
        $response = $this->createOrder($args);

        return  $response;
    }

    public function createOrder($data)
    {
        $order = Order::where('reference', $data['reference'])
            ->where('status', 'CREATED')
            ->orWhere('status', 'REJECTED')
            ->first();
        $reference = $order->reference;
        $request = [
            'locale' => 'es_CO',
            'payment' => [
                'reference' => $reference,
                'description' => 'Testing payment',
                'amount' => [
                    'currency' => 'USD',
                    'total' => $order->total,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => config('app.url').'/response?reference='.$reference,
            'cancelUrl' => config('app.url').'/rejected?reference='.$reference,
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36',
            'skipResult' => false,
            'noBuyerFill' => false,
            'captureAddress' => false,
            'paymentMethod' => null,
        ];

        $response = $this->placetopay->request($request);
        if ($response->isSuccessful()) {
            $order->update([
                'requestId' => $response->requestId(),
                'processUrl' => $response->processUrl(),
            ]);
            $response = $order;
        } else {
            // There was some error so check the message and log it
            $response->status()->message();
        }

        return $response;
    }
}
