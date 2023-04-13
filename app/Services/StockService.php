<?php

namespace App\Services;

use App\Contracts\StockServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Company;

class StockService implements StockServiceInterface
{
    protected $rapidApiHost;
    protected $rapidApiKey;

    public function __construct()
    {
        $this->rapidApiHost = config('services.rapid_api.host');
        $this->rapidApiKey = config('services.rapid_api.key');
    }

    public function getHistoricalData(string $symbol): array
    {
        $cacheKey = "historical-data-{$symbol}";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $response = Http::withHeaders([
            'X-RapidAPI-Key' => $this->rapidApiKey,
            'X-RapidAPI-Host' => $this->rapidApiHost,
        ])->get('https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data', [
            'symbol' => $symbol,
            'region' => 'US'
        ]);

        $historicalData = $response->json()['prices'] ?? [];

        $secondsUntilEndOfDay = now()->endOfDay()->diffInSeconds(now());

        Cache::put($cacheKey, $historicalData, $secondsUntilEndOfDay);

        return $historicalData;
    }

    public function getCompanyNameBySymbol($symbol) : string
    {
        return optional(Company::where('symbol', $symbol)->first())->name ?? '';
    }
}
