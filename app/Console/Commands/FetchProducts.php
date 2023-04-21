<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // call the api until all pages fetched
        
        // An alternate strategy would be to use the value of "@odata.count": 100, and query params ?$skip=10&$top=10", 
        // to just request all 100 records at once
        // but the problem here is that if the number of products increases over time to thousands 
        // the request might be too big and slow

        $this->info('Starting products update');
        $pageNumber = 1;

        $firstResponse = Http::get(config('app.product_api_url'));
        $this->info("Page $pageNumber");

        $firstResponse->json('value');
        $this->createOrUpdateProducts($firstResponse->json('value'));
        
        $nextLink = $firstResponse->json()['@odata.nextLink'];

        while($nextLink){
            $response = Http::get($nextLink);
            $pageNumber++;
            $this->info("Page $pageNumber");
            $this->createOrUpdateProducts($response->json('value'));
            $nextLink = $response->json()['@odata.nextLink']?? null;
        }
    }

    private function createOrUpdateProducts(array $productData): void
    {
        foreach($productData as $productDatum){

            $productCategory = ProductCategory::firstOrCreate([
                'name' => $productDatum['category']
            ]);

            $data = [
                'name' => $productDatum['product_name'],
                'weight' => $productDatum['weight'],
                'product_category_id' => $productCategory->id
            ];
            
            Product::updateOrCreate(
                ['sku' => $productDatum['sku']],
                $data
            );
        }
    }
}
