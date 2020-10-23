<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountController;

//Route::middleware(['auth:sanctum', 'verified'])
//    ->get('/dashboard/counts', [CountController::class,'index'])
//    ->name('counts.list');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/counts/create', [CountController::class,'create'])
    ->name('counts.create');

Route::middleware(['auth:sanctum', 'verified'])
    ->post('/dashboard/counts', [CountController::class,'store'])
    ->name('counts.store');

//Route::get('/counts/{count}', [CountController::class,'show'])
//    ->name('counts.show');

//Route::middleware(['auth:sanctum', 'verified'])
//    ->get('/dashboard/counts/{count}/edit', [CountController::class,'edit'])
//    ->name('counts.edit');

//Route::middleware(['auth:sanctum', 'verified'])
//    ->put('/dashboard/counts/{count}', [CountController::class,'update'])
//    ->name('counts.update');

Route::middleware(['auth:sanctum', 'verified'])
    ->delete('/dashboard/counts/{count}', [CountController::class,'destroy'])
    ->name('counts.delete');
