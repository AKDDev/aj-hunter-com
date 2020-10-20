<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;


Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/projects', [ProjectController::class,'index'])
    ->name('projects.list');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/projects/create', [ProjectController::class,'create'])
    ->name('projects.create');

Route::middleware(['auth:sanctum', 'verified'])
    ->post('/dashboard/projects', [ProjectController::class,'store'])
    ->name('projects.store');

Route::get('/projects/{project}', [ProjectController::class,'show'])
    ->name('projects.show');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/projects/{project}/edit', [ProjectController::class,'edit'])
    ->name('projects.edit');

Route::middleware(['auth:sanctum', 'verified'])
    ->put('/dashboard/projects/{project}', [ProjectController::class,'update'])
    ->name('projects.update');

Route::middleware(['auth:sanctum', 'verified'])
    ->delete('/dashboard/projects/{project}', [ProjectController::class,'destroy'])
    ->name('projects.delete');
