<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Contracts\StockServiceInterface;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function show(Request $request, StockServiceInterface $stockService, string $symbol, string $startDate, string $endDate)
    {
        $companyName = Company::where('symbol', $symbol)->first()->name;
        $historicalData = $stockService->getHistoricalData($symbol);

        return view('stocks.show', [
            'companyName' => $companyName,
            'symbol' => $symbol,
            'historicalData' => $historicalData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
