<?php


namespace App\Services\OrderState;


class CreatedOrderStatus extends OrderStatus
{
    public function getStatusName(): string
    {
        return 'created';
    }

    public function upgradeStatus(): OrderStatus
    {
        return new ProcessedOrderStatus();
    }

    public function lowerStatus(): OrderStatus
    {
        return new CancelledOrderStatus();
    }
}
