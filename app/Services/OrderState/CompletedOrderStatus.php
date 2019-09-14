<?php


namespace App\Services\OrderState;


class CompletedOrderStatus extends OrderStatus
{
    public function getStatusName(): string
    {
        return 'completed';
    }
}
