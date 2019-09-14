<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Services\OrderServiceContract;
use Exception;
use Mockery;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    private function createOrderMock(string $initialStatus)
    {
        $mockOrder = Mockery::mock(Order::class);

        $order = new Order();
        $order->id = 1;
        $order->status = $initialStatus;

        $mockOrder->shouldReceive('findOrFail')->once()->andReturn($order);

        $this->instance(Order::class, $mockOrder);
    }

    private function createExpectedOrder(string $expectedStatus)
    {
        $expectedOrder = new Order();
        $expectedOrder->id = 1;
        $expectedOrder->status = $expectedStatus;

        return $expectedOrder;
    }

    public function testUpgradeOrderStatusFromCreated(): void
    {
        $this->createOrderMock('created');

        $expectedOrder = $this->createExpectedOrder('processed');

        $actualOrder = app(OrderServiceContract::class)->upgradeStatus(1);

        $this->assertEquals($expectedOrder, $actualOrder);
    }

    public function testLowerOrderStatusFromCreated(): void
    {
        $this->createOrderMock('created');

        $expectedOrder = $this->createExpectedOrder('cancelled');

        $actualOrder = app(OrderServiceContract::class)->lowerStatus(1);

        $this->assertEquals($expectedOrder, $actualOrder);
    }

    public function testUpgradeOrderStatusFromProcessed(): void
    {
        $this->createOrderMock('processed');

        $expectedOrder = $this->createExpectedOrder('transferred_courier');

        $actualOrder = app(OrderServiceContract::class)->upgradeStatus(1);

        $this->assertEquals($expectedOrder, $actualOrder);
    }

    public function testLowerOrderStatusFromProcessed(): void
    {
        $this->createOrderMock('processed');

        $expectedOrder = $this->createExpectedOrder('cancelled');

        $actualOrder = app(OrderServiceContract::class)->lowerStatus(1);

        $this->assertEquals($expectedOrder, $actualOrder);
    }

    public function testUpgradeOrderStatusFromTransferredCourier(): void
    {
        $this->createOrderMock('transferred_courier');

        $expectedOrder = $this->createExpectedOrder('completed');

        $actualOrder = app(OrderServiceContract::class)->upgradeStatus(1);

        $this->assertEquals($expectedOrder, $actualOrder);
    }

    public function testLowerOrderStatusFromTransferredCourier(): void
    {
        $this->createOrderMock('transferred_courier');

        $expectedOrder = $this->createExpectedOrder('cancelled');

        $actualOrder = app(OrderServiceContract::class)->lowerStatus(1);

        $this->assertEquals($expectedOrder, $actualOrder);
    }

    public function testUpgradeOrderStatusFromCompleted(): void
    {
        $this->createOrderMock('completed');
        $this->expectException(Exception::class);

        app(OrderServiceContract::class)->upgradeStatus(1);
    }

    public function testLowerOrderStatusFromCompleted(): void
    {
        $this->createOrderMock('completed');
        $this->expectException(Exception::class);

        app(OrderServiceContract::class)->lowerStatus(1);
    }

    public function testUpgradeOrderStatusFromCancelled(): void
    {
        $this->createOrderMock('cancelled');
        $this->expectException(Exception::class);

        app(OrderServiceContract::class)->upgradeStatus(1);
    }

    public function testLowerOrderStatusFromCancelled(): void
    {
        $this->createOrderMock('cancelled');
        $this->expectException(Exception::class);

        app(OrderServiceContract::class)->lowerStatus(1);
    }
}
