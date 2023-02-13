<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ProfileController;
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

Route::middleware(['auth', 'role:SuperAdmin'])->name('admin.')->prefix('admin')->group(function() {
    // GET
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [UserManagementController::class, 'overview'])->name('users.overview');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::get('/users/edit/{user}', [UserManagementController::class, 'edit'])->name('users.edit');
    // POST
    Route::post('/users/create', [UserManagementController::class, 'store'])->name('users.store');
    Route::post('/users/update/{user}', [UserManagementController::class, 'update'])->name('users.update');
});

Route::middleware(['auth', 'role:StoreOwner'])->name('store.')->prefix('store')->group(function() {
    // GET
    Route::get('/users', [StoreUserController::class, 'overview'])->name('users.overview');
    Route::get('/users/create', [StoreUserController::class, 'create'])->name('users.create');
    Route::get('/users/edit/{user}', [StoreUserController::class, 'edit'])->name('users.edit');
    // POST
    Route::post('/users/create', [StoreUserController::class, 'store'])->name('users.store');
    Route::post('/users/update/{user}', [StoreUserController::class, 'update'])->name('users.update');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
