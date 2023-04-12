<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Facades\Http;

class CompanyService
{
    public function fetchAndStoreCompanies()
    {
        $url = 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json';
        $response = Http::get($url);

        if ($response->successful()) {
            $companies = json_decode($response->body(), true);

            foreach ($companies as $companyData) {
                Company::updateOrCreate(
                    ['symbol' => $companyData['Symbol']],
                    [
                        'name' => $companyData['Company Name'],
                        'symbol' => $companyData['Symbol'],
                        'security_name' => $companyData['Security Name'],
                        'market_category' => $companyData['Market Category'],
                        'financial_status' => $companyData['Financial Status'],
                        'test_issue' => $companyData['Test Issue'],
                        'round_lot_size' => $companyData['Round Lot Size'],
                    ]
                );
            }
        }
    }
}
