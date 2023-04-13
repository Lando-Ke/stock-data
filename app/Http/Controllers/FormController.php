<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

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

    public function submitForm(Request $request)
    {
        // Handle form submission here
    }
}
