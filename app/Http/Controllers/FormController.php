<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockFormRequest;
use App\Models\Company;
use App\Mail\StockDataMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
class FormController extends Controller
{
    public function createForm()
    {
        return view('_form');
    }

    public function showForm()
    {
        $symbols = Company::all()->map(function ($symbol) {
            return [
                'label' => "{$symbol->name} ({$symbol->symbol})",
                'value' => $symbol->symbol
            ];
        });

        return view('form', ['symbols' => $symbols]);
    }

    public function submitForm(StockFormRequest $request)
    {
        $symbol = $request->input('company-symbol');
        $startDate = $request->input('start-date');
        $endDate = $request->input('end-date');

       
        if (!app()->environment('local')) {
            try {
                Mail::to($request->email)->send(new StockDataMail($symbol, $startDate, $endDate));
                Session::flash('success', 'The email with historical stock data has been sent successfully!');
            } catch (\Exception $e) {
                Log::error('Error sending email: ' . $e->getMessage());
                Session::flash('error', 'There was a problem sending the email. Please try again later.');
            }
        }

        return redirect()->route('stocks.show', [
            'symbol' => $symbol, 
            'start_date' => $startDate, 
            'end_date' => $endDate
        ]);
    }
}
