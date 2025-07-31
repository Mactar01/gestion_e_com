<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;

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

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes Admin protégées par le middleware 'auth' (et futur 'is_admin')
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('orders', AdminOrderController::class);
    Route::resource('users', AdminUserController::class);
});

// Routes Front-Office
Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::resource('orders', OrderController::class)->middleware('auth');

// Routes Panier
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::post('cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])->middleware('auth')->name('orders.invoice');

Route::get('admin/orders/{order}/invoice', [\App\Http\Controllers\Admin\OrderController::class, 'downloadInvoice'])->middleware(['auth', 'is_admin'])->name('admin.orders.invoice');

require __DIR__.'/auth.php';
