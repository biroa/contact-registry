<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactRegistryController;
use App\Http\Controllers\DetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('contacts', ContactController::class);
Route::resource('details', DetailController::class);
Route::resource('addresses', AddressController::class);
Route::get('/contact-registry', [ContactRegistryController::class, 'index']);
