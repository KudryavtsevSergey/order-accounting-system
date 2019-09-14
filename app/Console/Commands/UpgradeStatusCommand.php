<?php

namespace App\Console\Commands;

use App\Services\OrderServiceContract;
use Exception;
use Illuminate\Console\Command;

class UpgradeStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accounting-system:upgrade-order {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade order status';

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
        $orderId = $this->argument('id');

        if (!is_numeric($orderId)) {
            $this->error("Incorrect order id.");
            return;
        }

        try {
            $order = $orderService->upgradeStatus($orderId);

            $this->info("Order id: {$order->id}. Status: {$order->status}.");
        } catch (Exception $exception) {
            $this->error("Order: {$orderId}.");
            $this->error($exception->getMessage());
        }
    }
}
