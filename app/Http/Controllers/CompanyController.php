<?php

namespace App\Http\Controllers;

use App\Contracts\StockServiceInterface;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{
    public function show(StockServiceInterface $stockService, string $symbol, string $startDate, string $endDate)
    {
        $companyName = $stockService->getCompanyNameBySymbol($symbol);
        $historicalData = $stockService->getHistoricalData($symbol);

        if (empty($historicalData)) {
            $message = $companyName
                ? "There is no data found for {$companyName} in the selected period."
                : "{$symbol} is not in our records.";
            Session::flash('warning', $message);
        }


        return view('stocks.show', [
            'companyName' => $companyName,
            'symbol' => $symbol,
            'historicalData' => $historicalData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
