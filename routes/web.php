<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CouponReportController;
use App\Http\Controllers\UserReportController;
use App\Http\Controllers\SaleReportController;
use App\Http\Controllers\BalanceReportController;
use App\Http\Controllers\GlobalReportController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
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
Route::group(['middleware' => ['auth']], function() {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/grupos', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/establecimientos', [StoreController::class, 'index'])->name('stores.index');
    Route::get('/respuestas', [ResponseController::class, 'index'])->name('response.index');
    Route::get('/campanas', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/campanas/{campaign}/medir', [NotificationController::class, 'stats'])->name('notifications.stats');

    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('users.create');
    Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');

    Route::resource('roles', RoleController::class, ['except' => ['store', 'update', 'destroy']]);
    Route::get('/permisos', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/menus', [MenuController::class, 'index'])->name('menu.index');

    //Calificaciones
    Route::get('/calificaciones', [ScoreController::class, 'index'])->name('scores');

    //Reportes
    Route::get('/reportes/cupones/impresos', [CouponReportController::class, 'printed'])->name('reports.coupons.printed');
    Route::get('/reportes/cupones/impresos/descargar/{data}', [CouponReportController::class, 'downloadPrinted'])->name('reports.coupons.printed.download');
    Route::get('/reportes/cupones/canjeados', [CouponReportController::class, 'redeemed'])->name('reports.coupons.redeemed');
    Route::get('/reportes/cupones/canjeados/descargar/{data}', [CouponReportController::class, 'downloadRedeemed'])->name('reports.coupons.redeemed.download');
    Route::get('/reportes/cupones/ultimo-impreso', [CouponReportController::class, 'lastPrinted'])->name('reports.coupons.last-printed');
    Route::get('/reportes/cupones/impresos-canjeados', [CouponReportController::class, 'printedRedeemed'])->name('reports.coupons.printed-redeemed');
    Route::get('/reportes/cupones/impresos-canjeados/descargar/{data}', [CouponReportController::class, 'downloadPrintedRedeemed'])->name('reports.coupons.printed-redeemed.download');
    Route::get('/reportes/cupones/detalle-canjes', [CouponReportController::class, 'detailRedeemed'])->name('reports.coupons.detail-redeemed');
    Route::get('/reportes/cupones/detalle-canjes/descargar/{data}', [CouponReportController::class, 'downloadDetailRedeemed'])->name('reports.coupons.detail-redeemed.download');
    Route::get('/reportes/cupones/historico', [CouponReportController::class, 'printedRedeemedHistory'])->name('reports.coupons.printed-redeemed-history');

    Route::get('/reportes/usuarios/nuevos', [UserReportController::class, 'new'])->name('reports.users.new');
    Route::get('/reportes/usuarios/nuevos/descargar/{data}', [UserReportController::class, 'downloadNew'])->name('reports.users.new.download');
    Route::get('/reportes/usuarios/historico', [UserReportController::class, 'history'])->name('reports.users.history');
    Route::get('/reportes/usuarios/historico/descargar/{data}', [UserReportController::class, 'downloadHistory'])->name('reports.users.history.download');
    Route::get('/reportes/usuarios/actividad', [UserReportController::class, 'activity'])->name('reports.users.activity');

    Route::get('/reportes/ventas/detalle-ventas', [SaleReportController::class, 'detail'])->name('reports.sales.detail');
    Route::get('/reportes/ventas/detalle-ventas/descargar/{data}', [SaleReportController::class, 'downloadDetailSales'])->name('reports.sales.detail.download');
    Route::get('/reportes/ventas/historico', [SaleReportController::class, 'history'])->name('reports.sales.history');
    Route::get('/reportes/ventas/ventas', [SaleReportController::class, 'sales'])->name('reports.sales.sales');
    Route::get('/reportes/ventas/ventas/descargar/{data}', [SaleReportController::class, 'downloadSales'])->name('reports.sales.sales.download');

    Route::get('/reportes/saldo', [BalanceReportController::class, 'balance'])->name('reports.balance');

    Route::get('/reportes/globales/canjes', [GlobalReportController::class, 'redeems'])->name('reports.globals.redeems');
    Route::get('/reportes/globales/canjes/descargar/{data}', [GlobalReportController::class, 'downloadRedeems'])->name('reports.globals.redeems.download');
    Route::get('/reportes/globales/altas', [GlobalReportController::class, 'registers'])->name('reports.globals.registers');
    Route::get('/reportes/globales/altas/descargar/{data}', [GlobalReportController::class, 'downloadRegisters'])->name('reports.globals.registers.download');


});

require __DIR__.'/auth.php';
