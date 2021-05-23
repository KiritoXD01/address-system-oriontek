<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ClientController;

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

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::prefix('user')->name('user.')->middleware(['auth'])->group(function(){
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::patch('/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'delete'])->name('delete');
});

Route::prefix('business')->name('business.')->middleware(['auth'])->group(function(){
    Route::get('/', [BusinessController::class, 'index'])->name('index');
    Route::post('/', [BusinessController::class, 'store'])->name('store');
    Route::patch('/{business}', [BusinessController::class, 'update'])->name('update');
});

Route::prefix('client')->name('client.')->middleware(['auth'])->group(function() {
    Route::get('/', [ClientController::class, 'index'])->name('index');
    Route::get('/create', [ClientController::class, 'create'])->name('create');
    Route::get('/{client}/edit', [ClientController::class, 'edit'])->name('edit');
    Route::post('/', [ClientController::class, 'store'])->name('store');
    Route::patch('/{client}', [ClientController::class, 'update'])->name('update');
    Route::delete('/{client}', [ClientController::class, 'delete'])->name('delete');
});

require __DIR__.'/auth.php';
