<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientAddressController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ForgotPasswordController;

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

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::post('/forgot-password', [ForgotPasswordController::class, 'submitForgotPassword'])->name('forgot.password');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPassword'])->name('reset.password.show');
Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.submit');

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/changeLanguage/{language}', function(string $language){
    session(['locale' => $language]);
    return redirect()->back();
})->name("changeLanguage");

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

Route::prefix('clientAddress')->name('clientAddress.')->middleware(['auth'])->group(function(){
    Route::get('/{client}/create', [ClientAddressController::class, 'create'])->name('create');
    Route::get('/{clientAddress}/edit', [ClientAddressController::class, 'edit'])->name("edit");
    Route::post('/', [ClientAddressController::class, 'store'])->name('store');
    Route::patch('/{clientAddress}', [ClientAddressController::class, 'update'])->name('update');
    Route::delete('/{clientAddress}', [ClientAddressController::class, 'delete'])->name('delete');
});
