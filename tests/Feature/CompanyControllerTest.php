<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function show_displays_correct_data_and_returns_a_view()
    {
        Company::factory()->create([
            'name' => 'Apple Inc.',
            'symbol' => 'AAPL',
        ]);

        $response = $this->get('/stocks/AAPL/2023-01-01/2023-01-10');

        $response->assertStatus(200);
        $response->assertViewIs('stocks.show');
        $response->assertViewHas('companyName', 'Apple Inc.');
        $response->assertViewHas('symbol', 'AAPL');
        $response->assertViewHas('historicalData');
        $response->assertViewHas('startDate', '2023-01-01');
        $response->assertViewHas('endDate', '2023-01-10');
    }
}
