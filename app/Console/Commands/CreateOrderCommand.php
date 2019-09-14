<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\OrderServiceContract;
use Illuminate\Console\Command;

class CreateOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accounting-system:create-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param OrderServiceContract $orderService
     * @return mixed
     */
    public function handle(OrderServiceContract $orderService)
    {
        $headers = ['ID', 'Name'];

        $products = Product::select('id', 'name')->get();

        $selectedProducts = collect();

        do {
            $currentStepProducts = $products->filter(function (Product $product) use ($selectedProducts): bool {
                return !$selectedProducts->contains($product->id);
            });

            if ($currentStepProducts->count() == 0) {
                $this->error('No products available');
                continue;
            }

            $this->table($headers, $currentStepProducts);

            $productId = $this->ask('Enter product id for buy');

            if (!is_numeric($productId)) {
                $this->error("Incorrect product id.");
                continue;
            }

            $currentStepProduct = $currentStepProducts->first(function (Product $currentStepProduct) use ($productId): bool {
                return $currentStepProduct->id == $productId;
            });

            if (empty($currentStepProduct)) {
                $this->error('You have selected a product that does not exist!');
                $this->info('Please select an existing product.');
                continue;
            }

            $selectedProducts->push($currentStepProduct->id);
        } while ($this->confirm('Do you wish buy one more product?'));

        if ($selectedProducts->count() < 1) {
            $this->error('Number of products smaller than one!');
            return;
        }

        $order = $orderService->store($selectedProducts->toArray());

        $this->info('Order created successfully.');
        $this->info("Order id: {$order->id}. Status: {$order->status}.");
    }
}
