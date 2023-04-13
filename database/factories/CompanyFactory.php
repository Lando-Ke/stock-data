<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'symbol' => $this->faker->unique()->bothify('???#'),
            'security_name' => $this->faker->word,
            'market_category' => $this->faker->randomElement(['A', 'B', 'C']),
            'financial_status' => $this->faker->randomElement(['Y', 'N']),
            'test_issue' => $this->faker->randomElement(['Y', 'N']),
            'round_lot_size' => $this->faker->randomFloat(0, 1, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
