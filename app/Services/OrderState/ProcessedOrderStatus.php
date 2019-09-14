<?php


namespace App\Services\OrderState;


class ProcessedOrderStatus extends OrderStatus
{
    public function getStatusName(): string
    {
        return 'processed';
    }

    public function upgradeStatus(): OrderStatus
    {
        return new TransferredCourierOrderStatus();
    }

    public function lowerStatus(): OrderStatus
    {
        return new CancelledOrderStatus();
    }
}
