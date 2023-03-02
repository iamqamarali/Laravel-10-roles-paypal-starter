<?php

use App\Http\Controllers\Admin\GroupsController;
use App\Http\Controllers\OnlineArbitrageLead\CheckoutController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';


// global routes
Route::get('/checkouts/online-arbitrage-lead', [CheckoutController::class, 'index'])->name('online-arbitrage-lead.checkout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



/**
 * admin dashboard
 */
Route::view('/dashboard', 'dashboard')->middleware(['auth'])->name('dashboard');
Route::resource('groups', GroupsController::class);


/**
 * customer area
 */
Route::get('/', [PagesController::class, 'home'])->name('home');
