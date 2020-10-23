<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard', function () {
        return view('dashboard');
    })
    ->name('dashboard');

Route::group([],base_path('routes/projects.php'));
Route::group([],base_path('routes/statuses.php'));
Route::group([],base_path('routes/types.php'));
Route::group([],base_path('routes/goals.php'));
Route::group([],base_path('routes/count.php'));
