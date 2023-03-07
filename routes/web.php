<?php

use App\Http\Controllers\Admin\AmazonProductsController;
use App\Http\Controllers\Admin\GroupsController;
use App\Http\Controllers\OnlineArbitrageLead\CheckoutController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Models\Subscription;
use Illuminate\Http\Request;
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
Route::get('/checkouts/online-arbitrage-lead', [CheckoutController::class, 'index'])->name('checkouts.online-arbitrage-lead');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


/**
 * admin dashboard
 */
Route::resource('groups', GroupsController::class);
Route::resource('groups.products', AmazonProductsController::class)
                ->shallow()
                ->only(['index', 'create', 'store', 'destroy']);
 

/**
 * customer area
 */
Route::get('/', [PagesController::class, 'dashboard'])->name('dashboard');


// paypal routes
Route::get('/subscription/initiate', [SubscriptionController::class, 'initiateSubscription'])->name('subscription.initiate');
Route::get('/subscription/success', [SubscriptionController::class, 'success'])->name('subscription.success');
Route::get('/subscription/failed', [SubscriptionController::class, 'failed'])->name('subscription.failed');
