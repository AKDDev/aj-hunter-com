<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeController;


Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/types', [TypeController::class,'index'])
    ->name('types.list');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/types/create', [TypeController::class,'create'])
    ->name('types.create');

Route::middleware(['auth:sanctum', 'verified'])
    ->post('/dashboard/types', [TypeController::class,'store'])
    ->name('types.store');

//Route::get('/types/{type}', [TypeController::class,'show'])
    //->name('types.show');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/types/{type}/edit', [TypeController::class,'edit'])
    ->name('types.edit');

Route::middleware(['auth:sanctum', 'verified'])
    ->put('/dashboard/types/{type}', [TypeController::class,'update'])
    ->name('types.update');

Route::middleware(['auth:sanctum', 'verified'])
    ->delete('/dashboard/types/{type}', [TypeController::class,'destroy'])
    ->name('types.delete');
