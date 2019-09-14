<?php


namespace App\Services\OrderState;


use Exception;

abstract class OrderStatus
{
    public abstract function getStatusName(): string;

    /**
     * @return OrderStatus
     * @throws Exception
     */
    public function upgradeStatus(): OrderStatus
    {
        throw new Exception("Order status cannot be upgraded.");
    }

    /**
     * @return OrderStatus
     * @throws Exception
     */
    public function lowerStatus(): OrderStatus
    {
        throw new Exception("Order status cannot be lowered.");
    }
}
