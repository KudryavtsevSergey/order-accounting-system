<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Services\OrderServiceContract;
use Tests\TestCase;

class OrderRestApiTest extends TestCase
{
    public function testCreateOrderSuccess(): void
    {
        $mockOrderService = $this->createMock(OrderServiceContract::class);

        $order = new Order();
        $order->id = 1;
        $order->status = 'created';

        $mockOrderService->method('store')
            ->willReturn($order);

        $this->instance(OrderServiceContract::class, $mockOrderService);

        $response = $this->json('POST', '/api/order', [
            'products' => [
                ['product_id' => 2],
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJson(['id' => 1, 'status' => 'created']);
    }

    public function testCreateOrderEmptyProducts(): void
    {
        $response = $this->json('POST', '/api/order');

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid.",
            "errors" => [
                "products" => [
                    "The products field is required."
                ]
            ]]);
    }

    public function testCreateOrderEmptyProductId(): void
    {
        $response = $this->json('POST', '/api/order', [
            'products' => [
                ['id' => 2],
            ]
        ]);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid.",
            "errors" => [
                "products.0.product_id" => [
                    "The products.0.product_id field is required."
                ]
            ]]);
    }

    public function testCreateOrderIncorrectProductId(): void
    {
        $response = $this->json('POST', '/api/order', [
            'products' => [
                ['product_id' => 'test'],
            ]
        ]);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid.",
            "errors" => [
                "products.0.product_id" => [
                    "The products.0.product_id must be a number."
                ]
            ]]);
    }

    public function testUpgradeOrderSuccess(): void
    {
        $mockOrderService = $this->createMock(OrderServiceContract::class);

        $order = new Order();
        $order->id = 1;
        $order->status = 'processed';

        $mockOrderService->method('upgradeStatus')
            ->willReturn($order);

        $this->instance(OrderServiceContract::class, $mockOrderService);

        $response = $this->json('POST', '/api/order/1/upgradeStatus');

        $response->assertStatus(200);
        $response->assertJson(['id' => 1, 'status' => 'processed']);
    }

    public function testUpgradeOrderIncorrectOrderId(): void
    {
        $response = $this->json('POST', '/api/order/test/upgradeStatus');

        $response->assertStatus(404);
    }

    public function testUpgradeOrderNotExistOrderId(): void
    {
        $response = $this->json('POST', '/api/order/0/upgradeStatus');

        $response->assertStatus(404);
        $response->assertJson([
            "message" => "Order not found."
        ]);
    }

    public function testLowerOrderSuccess(): void
    {
        $mockOrderService = $this->createMock(OrderServiceContract::class);

        $order = new Order();
        $order->id = 1;
        $order->status = 'cancelled';

        $mockOrderService->method('lowerStatus')
            ->willReturn($order);

        $this->instance(OrderServiceContract::class, $mockOrderService);

        $response = $this->json('POST', '/api/order/1/lowerStatus');

        $response->assertStatus(200);
        $response->assertJson(['id' => 1, 'status' => 'cancelled']);
    }

    public function testLowerOrderIncorrectOrderId(): void
    {
        $response = $this->json('POST', '/api/order/test/lowerStatus');

        $response->assertStatus(404);
    }

    public function testLowerOrderNotExistOrderId(): void
    {
        $response = $this->json('POST', '/api/order/0/lowerStatus');

        $response->assertStatus(404);
        $response->assertJson([
            "message" => "Order not found."
        ]);
    }
}
