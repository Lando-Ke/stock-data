<?php

namespace Tests\Feature;

use App\Mail\StockDataMail;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class FormControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function show_form_displays_symbols_and_returns_a_view()
    {
        Company::factory()->create([
            'name' => 'Apple Inc.',
            'symbol' => 'AAPL',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('form');
        $response->assertViewHas('symbols');
    }

    /** @test */
    public function submit_form_sends_email_and_redirects_to_stock_show()
    {
        Mail::fake();

        Company::factory()->create([
            'name' => 'Apple Inc.',
            'symbol' => 'AAPL',
        ]);

        $data = [
            'company-symbol' => 'AAPL',
            'start-date' => '2023-01-01',
            'end-date' => '2023-01-10',
            'email' => 'john@example.com',
        ];

        $response = $this->post('/submit', $data);

        Mail::assertSent(StockDataMail::class, function ($mail) use ($data) {
            return $mail->hasTo($data['email']);
        });

        $response->assertStatus(302);
        $response->assertRedirect('/stocks/AAPL/2023-01-01/2023-01-10');
    }
}
