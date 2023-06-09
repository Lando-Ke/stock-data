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

Route::get('/', [FormController::class, 'showForm'])->name('show-form');
Route::post('/submit', [FormController::class, 'submitForm'])->name('submit-form');

Route::get('stocks/{symbol}/{start_date}/{end_date}', [CompanyController::class, 'show'])->name('stocks.show');