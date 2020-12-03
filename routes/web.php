<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [SiteController::class,'index'])
    ->name('home');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard', [DashboardController::class,'index'])
    ->name('dashboard');

Route::group([],base_path('routes/projects.php'));
Route::group([],base_path('routes/statuses.php'));
Route::group([],base_path('routes/types.php'));
Route::group([],base_path('routes/goals.php'));
Route::group([],base_path('routes/count.php'));
