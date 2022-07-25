<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\maintenance\MaintenanceController;

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
$op = 1;
if ($op == 0) {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });
} else {
    Route::get('/', function () {
        return view('auth.login');
    });
    
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
        Route::get('/dash', function () {
            return view('dvhive.dash.index');
        })->name('dash');
    });
    
    Route::get(
        'maintenance',
        [MaintenanceController::class, 'index']
    )->name('maintenance');
    
    Route::post(
        'maintenance/find',
        [MaintenanceController::class, 'findStudent']
    )->name('maintenance/findStudent');
    
    Route::put(
        'maintenance/update',
        [MaintenanceController::class, 'updateStudent']
    )->name('maintenance/updateStudent');
    
    Route::get('/incidencia', function () {
        return view('dvhive.incidencia.index');
    });
}
