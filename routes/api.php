<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/transactions', function (Request $request) {
    return $request->user()->transactions()
        ->latest('date')
        ->limit(100)
        ->get()
        ->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'date' => $transaction->date->format('d/m/Y'),
                'description' => $transaction->description,
                'formatted_amount' => number_format($transaction->amount, 2) . ' €'
            ];
        });
});
