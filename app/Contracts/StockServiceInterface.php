<?php

namespace App\Contracts;

interface StockServiceInterface
{
    public function getHistoricalData(string $symbol): array;
}
