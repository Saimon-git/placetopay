<?php

namespace Tests\Feature;

use App\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order()
    {
        $user = $this->signIn();

        $data = factory(Order::class)->make([
            'phone' => '3508601978',
        ]);

        $response = $this->graphQL('
            mutation {
                createOrder(input: {
                    total: "'.$data->total.'",
                    phone: "'.$data->phone.'",
                }) {
                    id
                    total
                }
            }
        ');

        $response->assertJson([
            'data'  => [
                'createOrder' => [
                    'total'  => $data->total,
                ],
            ],
        ]);

        $this->assertDatabaseHas('orders', [
            'total'      => $data->total,
            'user_id'   => $user->id,
        ]);
    }

    public function test_pay_order()
    {
        $user = $this->signIn();
        $fakedata = factory(Order::class)->make([
            'phone' => '3508601978',
        ]);

        $data = factory(Order::class)->create([
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_mobile' => $fakedata->phone,
            'user_id' => $user->id,
            'status' => 'CREATED',
            'reference' => time(),
        ]);
        $response = $this->graphQL('
            mutation {
                payOrder(input: {
                    reference: "'.$data->reference.'",
                }) {
                    reference
                }
            }
        ');

        $response->assertJson([
            'data'  => [
                'payOrder' => [
                    'reference' =>$data->reference,
                ],
            ],
        ]);

        $order = Order::where('reference', $data->reference)->first();

        $this->assertNotNull($order->processUrl);
        $this->assertDatabaseHas('orders', [
            'processUrl'      => $order->processUrl,
            'user_id'   => $user->id,
        ]);
    }
}
