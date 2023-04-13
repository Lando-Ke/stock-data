<?php

namespace Tests\Unit;

use App\Services\StockService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class StockServiceTest extends TestCase
{
    use RefreshDatabase;

    protected StockService $stockService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stockService = app(StockService::class);
    }

    /** @test */
    public function get_historical_data_returns_data_for_given_symbol()
    {
        $symbol = 'AAPL';

        // Mock the API response with sample data
        Http::fake([
            'https://yh-finance.p.rapidapi.com/*' => Http::response([
                'prices' => [
                    [
                        'date' => 1620000000,
                        'open' => 100,
                        'high' => 105,
                        'low' => 95,
                        'close' => 103,
                        'volume' => 1000000,
                    ],
                ],
            ]),
        ]);

        $historicalData = $this->stockService->getHistoricalData($symbol);

        $this->assertNotEmpty($historicalData);
        $this->assertEquals([
            'date' => 1620000000,
            'open' => 100,
            'high' => 105,
            'low' => 95,
            'close' => 103,
            'volume' => 1000000,
        ], $historicalData[0]);
    }

    /** @test */
    public function get_historical_data_caches_data_until_end_of_day()
    {
        $symbol = 'AAPL';

        // Mock the API response with sample data
        Http::fake([
            'https://yh-finance.p.rapidapi.com/*' => Http::response([
                'prices' => [
                    [
                        'date' => 1620000000,
                        'open' => 100,
                        'high' => 105,
                        'low' => 95,
                        'close' => 103,
                        'volume' => 1000000,
                    ],
                ],
            ]),
        ]);

        $this->stockService->getHistoricalData($symbol);

        $cacheKey = "historical-data-{$symbol}";

        $this->assertTrue(Cache::has($cacheKey));

        $cachedData = Cache::get($cacheKey);

        $this->assertEquals([
            'date' => 1620000000,
            'open' => 100,
            'high' => 105,
            'low' => 95,
            'close' => 103,
            'volume' => 1000000,
        ], $cachedData[0]);
    }

    /** @test */
    public function get_company_name_by_symbol_returns_company_name()
    {
        $symbol = 'AAPL';
        $companyName = 'Apple Inc.';

        // Create a sample company record
        \App\Models\Company::factory()->create([
            'symbol' => $symbol,
            'name' => $companyName,
        ]);

        $result = $this->stockService->getCompanyNameBySymbol($symbol);

        $this->assertEquals($companyName, $result);
    }
}
