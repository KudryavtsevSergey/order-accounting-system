<?php


namespace App\Services\OrderState;


class TransferredCourierOrderStatus extends OrderStatus
{
    public function getStatusName(): string
    {
        return 'transferred_courier';
    }

    public function upgradeStatus(): OrderStatus
    {
        return new CompletedOrderStatus();
    }

    public function lowerStatus(): OrderStatus
    {
        return new CancelledOrderStatus();
    }
}
