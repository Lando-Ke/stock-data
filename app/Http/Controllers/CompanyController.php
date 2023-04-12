<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function autocompleteSearch(Request $request)
    {
          $query = $request->get('query');

          $filterResult = Company::where('name', 'LIKE', '%'. $query. '%')
          ->orWhere('symbol', 'LIKE', '%'. $query. '%')
          ->get();

          return response()->json($filterResult);
    } 
}
