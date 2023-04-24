<?php

namespace App\Providers;

use App\Services\CsvImportService;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\CsvImporterInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CsvImporterInterface::class, CsvImportService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
