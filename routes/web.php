<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Customer\TrackingController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Store\LabelController;
use App\Http\Controllers\Store\PickupController;
use App\Http\Controllers\Store\ReviewController;
use App\Http\Controllers\Store\ShipmentController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\Store\StoreUserController;
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
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('language/switch/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Customers
Route::get('customer/tracking/overview-tracking', [TrackingController::class, 'overviewTracking'])->name('customer.tracking.overview-tracking');
Route::get('customer/tracking/overview', [TrackingController::class, 'overview'])->name('customer.tracking.overview');
Route::get('customer/tracking/not-found', [TrackingController::class, 'notfound'])->name('customer.tracking.not-found');
Route::post('customer/tracking/review/{shipment}', [TrackingController::class, 'review'])->name('customer.tracking.review');

Route::middleware(['auth', 'role:Customer'])->group(function() {
    Route::post('customer/tracking/save', [TrackingController::class, 'save'])->name('customer.tracking.save');
    Route::post('customer/tracking/delete/{shipment_id}', [TrackingController::class, 'delete'])->name('customer.tracking.delete');
});

Route::middleware(['auth', 'role:SuperAdmin'])->name('admin.')->prefix('admin')->group(function() {
    // GET
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [UserManagementController::class, 'overview'])->name('users.overview');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::get('/users/edit/{user}', [UserManagementController::class, 'edit'])->name('users.edit');
    // POST
    Route::post('/users/create', [UserManagementController::class, 'store'])->name('users.store');
    Route::post('/users/update/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::post('/users/delete/{user}', [UserManagementController::class, 'delete'])->name('users.delete');
});

Route::middleware(['auth', 'can:access store'])->name('store.')->prefix('store')->group(function() {
    Route::middleware('can:manage store')->group(function() {
        // USER
        Route::get('/users', [StoreUserController::class, 'overview'])->name('users.overview');
        Route::get('/users/create', [StoreUserController::class, 'create'])->name('users.create');
        Route::get('/users/edit/{user}', [StoreUserController::class, 'edit'])->name('users.edit')->middleware('can:user-in-store,user');

        // STORE
        Route::get('/stores', [StoreController::class, 'overview'])->name('stores.overview');
        Route::get('/stores/create', [StoreController::class, 'create'])->name('stores.create');
        Route::get('/stores/edit/{store}', [StoreController::class, 'edit'])->name('stores.edit')->middleware('can:store-in-auth-user,store');
        Route::post('/stores/create', [StoreController::class, 'store'])->name('stores.store');
        Route::post('/stores/delete/{store}', [StoreController::class, 'delete'])->name('stores.delete')->middleware('can:store-in-auth-user,store');
        Route::post('/stores/update/{store}', [StoreController::class, 'update'])->name('stores.update')->middleware('can:store-in-auth-user,store');
        Route::post('/stores/update-address/{store}', [StoreController::class, 'updateAddress'])->name('stores.updateAddress')->middleware('can:store-in-auth-user,store');

        // USER
        Route::post('/users/create', [StoreUserController::class, 'store'])->name('users.store');
        Route::post('/users/update/{user}', [StoreUserController::class, 'update'])->name('users.update')->middleware('can:user-in-store,user');
        Route::post('/users/delete/{user}', [StoreUserController::class, 'delete'])->name('users.delete')->middleware('can:user-in-store,user');

        // REVIEW
        Route::get('/reviews', [ReviewController::class, 'overview'])->name('reviews.overview')->middleware('selected-store');
    });


    // Middleware to ensure valid store is selected
    Route::middleware('selected-store')->group(function() {
        // SHIPMENT
        Route::get('/shipments', [ShipmentController::class, 'overview'])->name('shipments.overview')->middleware('can:read store');
        Route::post('/shipments/import', [ShipmentController::class, 'importShipment'])->name('shipments.import')->middleware('can:read store');

        // PICKUP
        Route::get('/pickups', [PickupController::class, 'overview'])->name('pickups.overview')->middleware('can:read store');
        Route::get('/pickups/create', [PickupController::class, 'create'])->name('pickups.create')->middleware('can:read store');
        Route::post('/pickups/create', [PickupController::class, 'store'])->name('pickups.store')->middleware('can:read store');

        // LABEL
        Route::get('/labels/createForm', [LabelController::class, 'createForm'])->name('labels.createForm')->middleware(['labeling-allowed', 'can:read store']);
        Route::post('/labels/create', [LabelController::class, 'store'])->name('labels.create')->middleware(['labeling-allowed', 'can:read store']);
    });

    // POST
    Route::post('/stores/switch/{store}', [StoreController::class, 'switch'])->name('stores.switch')->middleware('can:store-in-user,store');
    Route::post('/stores/update-address/{store}', [StoreController::class, 'updateAddress'])->name('stores.updateAddress')->middleware('can:store-in-auth-user,store');
    Route::post('/stores/createToken', [StoreController::class, 'storeToken'])->name('tokens.create');
    Route::post('/stores/deleteToken/{webstoreToken}', [StoreController::class, 'deleteToken'])->name('tokens.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
