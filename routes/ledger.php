<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewLedgerController;

Route::middleware('auth')->controller(NewLedgerController::class)->group(function () {
    // new routes 
    // get ledger info 
    Route::post('/ledger/check/excel/{year}', 'getLedgerMainInfo');
    // new import cycle modal month year
    Route::post('/import/ledger/cycles/modal/{month}/{year}', 'storeCyclesLedger')->name('newLedgerCyclesModal');
    // submit import payments in ledger cycle
    Route::post('/import/ledger/payments/{cycle}', 'storePaysLedger')->name('newLedgerPaysCyclesModal');
    // get payments ledger info 
    Route::post('/payments/check/excel/{month}/{year}', 'getPaymentsMainInfo');
    // submit import monthly payments & welfares in ledger cycle
    Route::post('/import/ledger/monthly/{cycle}', 'storePaysMonthly')->name('newLedgerPaysMonthlyModal');
});