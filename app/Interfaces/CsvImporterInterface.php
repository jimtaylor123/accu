<?php

namespace App\Interfaces;

use App\Models\Order;

interface CsvImporterInterface
{
	public function import(string $filePath): void;

	public function readCSVFile(string $filePath): array;

	public function getOrder(array $orderItemData): Order;
}