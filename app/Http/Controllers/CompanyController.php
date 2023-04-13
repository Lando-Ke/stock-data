<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Contracts\StockServiceInterface;

class CompanyController extends Controller
{
    public function show(StockServiceInterface $stockService, string $symbol, string $startDate, string $endDate)
    {
        $historicalData = $stockService->getHistoricalData($symbol);

        return view('stocks.show', [
            'companyName' => $stockService->getCompanyNameBySymbol($symbol),
            'symbol' => $symbol,
            'historicalData' => $historicalData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
