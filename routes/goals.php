<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoalController;

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/goals', [GoalController::class,'index'])
    ->name('goals.list');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/goals/create', [GoalController::class,'create'])
    ->name('goals.create');

Route::middleware(['auth:sanctum', 'verified'])
    ->post('/dashboard/goals', [GoalController::class,'store'])
    ->name('goals.store');

Route::get('/goals/{goal}', [GoalController::class,'show'])
    ->name('goals.show');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/goals/{goal}/edit', [GoalController::class,'edit'])
    ->name('goals.edit');

Route::middleware(['auth:sanctum', 'verified'])
    ->put('/dashboard/goals/{goal}', [GoalController::class,'update'])
    ->name('goals.update');

Route::middleware(['auth:sanctum', 'verified'])
    ->delete('/dashboard/goals/{goal}', [GoalController::class,'destroy'])
    ->name('goals.delete');
