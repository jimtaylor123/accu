<?php 

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Interfaces\CsvImporterInterface;
use App\Jobs\UpdateOrderNamesAndWeights;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class CsvImportService implements CsvImporterInterface
{
    protected array $csvKeys = [
        "Order Id" => 0,
        "Customer Name" => 1,
        "SKU" => 2,
        "Quantity" => 3,
    ];

    private ConsoleOutput $output;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

    public function import(string $filePath): void
    {
        $orderItemsArray = $this->readCSVFile(storage_path($filePath));
        $updatedOrders = [];

        $this->output->writeln("Reading order item data");

        $bar = new ProgressBar($this->output, count($orderItemsArray));
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
            $this->output->writeln("Affected orders will be updated shortly - please wait");
            UpdateOrderNamesAndWeights::dispatch($updatedOrders);
        }
    }

    public function readCSVFile(string $filePath): array
    {
        $csvData = file_get_contents($filePath);
        $lines = explode(PHP_EOL, $csvData);
        $array = [];
        foreach ($lines as $line) {
            $array[] = str_getcsv($line);
        }
        return array_filter($array);
    }

    public function getOrder(array $orderItemData): Order
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