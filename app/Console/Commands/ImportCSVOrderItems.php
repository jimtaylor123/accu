<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Interfaces\CsvImporterInterface;

class ImportCSVOrderItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-csv-order-items {filePath=app/orders/orders.csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $filePath = 'app/orders/orders.csv';

    protected CsvImporterInterface $service;

    public function __construct(CsvImporterInterface $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->service->import($this->argument('filePath'));
    }
}
