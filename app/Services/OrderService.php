<?php


namespace App\Services;


use App\Events\ChangedOrderStatusEvent;
use App\Models\Order;
use App\Services\OrderState\OrderStatus;
use Exception;
use Illuminate\Database\Eloquent\Model;

class OrderService implements OrderServiceContract
{
    /**
     * @var Order
     */
    protected $order;

    /**
     * OrderService constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @param array $products
     * @return Model
     */
    public function store(array $products): Model
    {
        $order = $this->order->create(['status' => 'created']);

        $order->products()->attach($products);

        return $order;
    }

    /**
     * @param int $id
     * @return Model
     * @throws Exception
     */
    public function upgradeStatus(int $id): Model
    {
        return $this->changeStatus($id, function (OrderStatus $status) {
            return $status->upgradeStatus();
        });
    }

    /**
     * @param int $id
     * @return Model
     * @throws Exception
     */
    public function lowerStatus(int $id): Model
    {
        return $this->changeStatus($id, function (OrderStatus $status) {
            return $status->lowerStatus();
        });
    }

    /**
     * @param int $id
     * @param callable $callback
     * @return Model
     */
    private function changeStatus(int $id, callable $callback): Model
    {
        $order = $this->order->findOrFail($id);

        $orderStatus = $this->generateOrderClass($order->status);

        $order->status = $callback($orderStatus)->getStatusName();

        $order->update();

        event(new ChangedOrderStatusEvent($order));

        return $order;
    }

    /**
     * @param string $status
     * @return OrderStatus
     */
    private function generateOrderClass(string $status): OrderStatus
    {
        $statusParts = explode('_', $status);

        array_walk($statusParts, function (string &$statusPart) {
            $statusPart = ucfirst($statusPart);
        });

        $status = implode($statusParts);

        $className = "App\\Services\\OrderState\\{$status}OrderStatus";

        return new $className;
    }
}
