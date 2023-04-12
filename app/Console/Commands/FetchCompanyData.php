<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CompanyService;


class FetchCompanyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:company-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store NASDAQ Listed company data';

    private $companyService;

    public function __construct(CompanyService $companyService)
    {
        parent::__construct();
        $this->companyService = $companyService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching company data...');
        $this->companyService->fetchAndStoreCompanies();
        $this->info('Company data fetched and stored successfully.');
    }
}
