<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(\App\Http\Controllers\SetController::class)->group(function () {
    Route::get('/sets', 'all');
    Route::get('/sets/{id}', 'find');
    Route::post('/sets', 'create');
    Route::put('/sets/{id}', 'update');
    Route::delete('/sets/{id}', 'delete');
});
