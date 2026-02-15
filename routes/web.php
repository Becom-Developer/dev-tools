<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreditCsvController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/menu', function () {
    return view('menu');
});
Route::resource('/credit-csv', CreditCsvController::class);
