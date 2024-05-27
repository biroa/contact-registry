<?php

use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/contacts', function () {
    return new ContactResource(Contact::all());
});

Route::get('/contact/{id}', function (string $id) {
    return new ContactResource(Contact::findOrFail($id));
});
