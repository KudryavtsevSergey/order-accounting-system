<?php


namespace App\Services\OrderState;


class CancelledOrderStatus extends OrderStatus
{
    public function getStatusName(): string
    {
        return 'cancelled';
    }
}
