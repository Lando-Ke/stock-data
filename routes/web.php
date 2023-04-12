<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\CompanyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [FormController::class, 'createForm']);
Route::get('/autocomplete-search', [CompanyController::class, 'autocompleteSearch']);
//create a named route call quote.get
Route::post('/quote', [FormController::class, 'getQuote'])->name('quote.get');