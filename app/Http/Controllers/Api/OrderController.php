<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Services\OrderServiceContract;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * @var OrderServiceContract
     */
    protected $orderService;

    /**
     * OrderController constructor.
     * @param OrderServiceContract $orderService
     */
    public function __construct(OrderServiceContract $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateOrderRequest $request
     * @return JsonResponse
     */
    public function store(CreateOrderRequest $request)
    {
        $products = $request->input('products');
        $products = array_column($products, 'product_id');

        $order = $this->orderService->store($products);

        return response()->json($order);
    }

    public function upgradeStatus(int $id)
    {
        try {
            $order = $this->orderService->upgradeStatus($id);

            return response()->json($order);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Order not found.'], 404);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }
    }

    public function lowerStatus(int $id)
    {
        try {
            $order = $this->orderService->lowerStatus($id);

            return response()->json($order);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Order not found.'], 404);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }
    }
}
