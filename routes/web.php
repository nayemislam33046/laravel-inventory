<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
Route::middleware('guest')->get('/', function () {
    return view('auth.login');
});
 Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //product list
    Route::get('/productlist', [ProductController::class, 'index'])->name('products.index');
    Route::get('/productaddview', [ProductController::class, 'create'])->name('products.create');
    Route::get('/productedit/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/productupdate/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::post('/productadd', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/productdelete/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    //category route
    Route::resource('/categories', CategoryController::class);
});
require __DIR__.'/auth.php';