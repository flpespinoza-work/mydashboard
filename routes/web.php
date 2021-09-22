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
    Route::get('/campanas/{campana}/medir', [NotificationController::class, 'stats'])->name('notifications.stats');

    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('users.create');
    Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');

    Route::resource('roles', RoleController::class, ['except' => ['store', 'update', 'destroy']]);
    Route::get('/permisos', [PermissionController::class, 'index'])->name('permissions.index');

    //Calificaciones
    Route::get('/calificaciones', [ScoreController::class, 'index'])->name('scores');

    //Reportes
    Route::get('/reportes/cupones/impresos', [CouponReportController::class, 'printed'])->name('reports.coupons.printed');
    Route::get('/reportes/cupones/canjeados', [CouponReportController::class, 'redeemed'])->name('reports.coupons.redeemed');
    Route::get('/reportes/cupones/ultimo-impreso', [CouponReportController::class, 'lastPrinted'])->name('reports.coupons.last-printed');
    Route::get('/reportes/cupones/impresos-canjeados', [CouponReportController::class, 'printedRedeemed'])->name('reports.coupons.printed-redeemed');
    Route::get('/reportes/cupones/detalle-canjes', [CouponReportController::class, 'detailRedeemed'])->name('reports.coupons.detail-redeemed');
    Route::get('/reportes/cupones/historico', [CouponReportController::class, 'printedRedeemedHistory'])->name('reports.coupons.printed-redeemed-history');

    Route::get('/reportes/usuarios/nuevos', [UserReportController::class, 'new'])->name('reports.users.new');
    Route::get('/reportes/usuarios/historico', [UserReportController::class, 'history'])->name('reports.users.history');
    Route::get('/reportes/usuarios/actividad', [UserReportController::class, 'activity'])->name('reports.users.activity'); //Agregar al menu y las vistas.

    Route::get('/reportes/ventas/detalle-ventas', [SaleReportController::class, 'detail'])->name('reports.sales.detail');
    Route::get('/reportes/ventas/historico', [SaleReportController::class, 'history'])->name('reports.sales.history');
    Route::get('/reportes/ventas/ventas', [SaleReportController::class, 'sales'])->name('reports.sales.sales');

    Route::get('/reportes/saldo', [BalanceReportController::class, 'balance'])->name('reports.balance');

    Route::get('/reportes/globales/redeems', [GlobalReportController::class, 'redeems'])->name('reports.globals.redeems');
    Route::get('/reportes/globales/registers', [GlobalReportController::class, 'registers'])->name('reports.globals.registers');

});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
*/
require __DIR__.'/auth.php';
