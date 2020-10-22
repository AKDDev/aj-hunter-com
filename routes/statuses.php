<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatusController;


Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/statuses', [StatusController::class,'index'])
    ->name('statuses.list');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/statuses/create', [StatusController::class,'create'])
    ->name('statuses.create');

Route::middleware(['auth:sanctum', 'verified'])
    ->post('/dashboard/statuses', [StatusController::class,'store'])
    ->name('statuses.store');

//Route::get('/statuses/{status}', [StatusController::class,'show'])
    //->name('statuses.show');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/statuses/{status}/edit', [StatusController::class,'edit'])
    ->name('statuses.edit');

Route::middleware(['auth:sanctum', 'verified'])
    ->put('/dashboard/statuses/{status}', [StatusController::class,'update'])
    ->name('statuses.update');

Route::middleware(['auth:sanctum', 'verified'])
    ->delete('/dashboard/statuses/{status}', [StatusController::class,'destroy'])
    ->name('statuses.delete');
