<?php

namespace App\Http\Controllers;

use App\Order;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\Request;

class PaymentController extends Controller
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

    public function success()
    {
        $order = Order::where('reference', request('reference'))
           ->where('status', '<>', 'PAYED')
            ->first();
        $response = $this->placetopay->query($order->requestId);

        if ($response->isSuccessful()) {
            // In order to use the functions please refer to the Dnetix\Redirection\Message\RedirectInformation class

            if ($response->status()->isApproved()) {
                $order->status = 'PAYED';
                $order->save();

                return view('payments.success');
                // The payment has been approved
            }
        } else {
            // There was some error with the connection so check the message
            $order->status = 'REJECTED';
            $order->save();

            return view('payments.rejected');
            print_r($response->status()->message()."\n");
        }
    }

    public function rejected()
    {
        $order = Order::where('reference', request('reference'))
            ->first();

        $order->status = 'REJECTED';
        $order->save();

        return view('payments.rejected');
    }
}
