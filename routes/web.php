<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/pending-approval', function () {
    return view('pending-approval');
})->name('pending-approval');

Route::get('/invoice/{invoice}/pdf', \App\Http\Controllers\InvoicePdfController::class)
    ->middleware('auth')
    ->name('invoice.pdf');
