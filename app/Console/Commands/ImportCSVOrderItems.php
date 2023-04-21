<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Console\Command;

class ImportCSVOrderItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-csv-order-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $filePath = 'app/orders/orders.csv';

    protected array $csvKeys = [
        "Order Id" => 0,
        "Customer Name" => 1,
        "SKU" => 2,
        "Quantity" => 3,
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderItemsArray = $this->readCSVFile(storage_path($this->filePath));
        $updatedOrders = [];

        $this->info("Reading order item data");
        $bar = $this->output->createProgressBar(count($orderItemsArray));
        $bar->start();

        foreach($orderItemsArray as $key => $orderItemData){
            if($key === 0){
                foreach($this->csvKeys as $name => $number){
                    $this->csvKeys[$name] = array_search($name, $orderItemData)?? $number;
                }
                continue;
            }
            if(! isset($orderItemData[1])){
                continue;
            }
            $order = $this->getOrder($orderItemData);
            $product = Product::where('sku', $orderItemData[$this->csvKeys['SKU']])->first();
            $updatedOrders[] = $order;

            OrderItem::updateOrCreate([
                'order_id' => $order->id,
                'product_id' => $product->id
            ],[
                'quantity' => $orderItemData[$this->csvKeys['Quantity']]
            ]);

            $bar->advance();
        }

        $bar->finish();

        if(count($updatedOrders) > 0){
            $this->info("Updating orders");
            $bar = $this->output->createProgressBar(count($updatedOrders));
            $bar->start();
            foreach($updatedOrders as $updatedOrder){
                $updatedOrder->recalculateTotalWeight();
                if(!$updatedOrder->name){
                    $updatedOrder->update(['name' => $updatedOrder->createAmusingName()]);
                }
                $bar->advance();
            }
            $bar->finish();
        }

    }

    private function readCSVFile(string $filePath): array
    {
        $csvData = file_get_contents($filePath);
        $lines = explode(PHP_EOL, $csvData);
        $array = [];
        foreach ($lines as $line) {
            $array[] = str_getcsv($line);
        }
        return array_filter($array);
    }

    private function getOrder(array $orderItemData)
    {
        $customer = Customer::firstOrCreate(['name' => $orderItemData[$this->csvKeys["Customer Name"]]]);
        $order = Order::where('csv_id', $orderItemData[$this->csvKeys["Order Id"]])->first();
        if(! $order){
            $order = Order::create([
                'csv_id' => $orderItemData[$this->csvKeys["Order Id"]],
                'customer_id' => $customer->id
            ]);
        }
        return $order;
    }
}
