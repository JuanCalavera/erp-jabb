<?php

use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\ProductsController;
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

Route::prefix(
    '/enterprise'
)->group(
    function () {
        Route::get('/', [EnterpriseController::class, 'index'])->name('all.enterprise');
        Route::post('/', [EnterpriseController::class, 'store'])->name('create.enterprise');
        Route::post('/update-enterprise', [EnterpriseController::class, 'updateEnterprise'])->name('update.enterprise');
        Route::get('/{enterprise}', [EnterpriseController::class, 'show'])->name('show.enterprise');
        Route::delete('/{enterprise}', [EnterpriseController::class, 'destroy'])->name('delete.enterprise');
    }
);

Route::prefix(
    '/produtos'
)->group(
    function () {
        Route::get('/', [ProductsController::class, 'index'])->name('all.products');
        Route::post('/', [ProductsController::class, 'store'])->name('create.products');
        Route::post('/update-products', [ProductsController::class, 'updateEnterprise'])->name('update.products');
        Route::get('/{products}', [ProductsController::class, 'show'])->name('show.products');
        Route::delete('/{products}', [ProductsController::class, 'destroy'])->name('delete.products');
    }
);

Route::view('/', 'home');