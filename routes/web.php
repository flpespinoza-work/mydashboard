<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CouponReportController;

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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/grupos', [GroupController::class, 'index'])->name('groups.index');
Route::get('/establecimientos', [StoreController::class, 'index'])->name('stores.index');
Route::get('/respuestas', [ResponseController::class, 'index'])->name('responses.index');

//Reportes
Route::get('/reportes/cupones/impresos', [CouponReportController::class, 'printed'])->name('reports.coupons.printed');
Route::get('/reportes/cupones/canjeados', [CouponReportController::class, 'redeemed'])->name('reports.coupons.redeemed');
Route::get('/reportes/cupones/ultimo-impreso', [CouponReportController::class, 'lastPrinted'])->name('reports.coupons.last-printed');
Route::get('/reportes/cupones/impresos-canjeados', [CouponReportController::class, 'printedRedeemed'])->name('reports.coupons.printed-redeemed');
Route::get('/reportes/cupones/detalle-canjes', [CouponReportController::class, 'detailRedeemed'])->name('reports.coupons.detail-redeemed');
Route::get('/reportes/cupones/historico', [CouponReportController::class, 'printedRedeemedHistory'])->name('reports.coupons.printed-redeemed-history');


/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
*/
require __DIR__.'/auth.php';
