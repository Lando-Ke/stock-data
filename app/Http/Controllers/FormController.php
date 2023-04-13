<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockFormRequest;
use App\Models\Company;
use App\Mail\StockDataMail;
use Illuminate\Support\Facades\Mail;
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
            Mail::to($request->email)->send(new StockDataMail($symbol, $startDate, $endDate));
        }

        return redirect()->route('stocks.show', [
            'symbol' => $symbol, 
            'start_date' => $startDate, 
            'end_date' => $endDate
        ]);
    }
}
