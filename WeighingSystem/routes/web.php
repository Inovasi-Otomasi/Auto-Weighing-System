<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatatablesController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SetupController;
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

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/export', [DashboardController::class, 'export'])->name('export')->middleware('auth');
//setup
Route::get('/setup', [SetupController::class, 'index'])->middleware('auth');
Route::get('/sku', [SetupController::class, 'sku'])->middleware('auth');
//sku
Route::post('/sku_list', [DatatablesController::class, 'skuList'])->middleware('auth');
Route::post('/add_sku', [DatatablesController::class, 'addSKU'])->middleware('auth');
Route::put('/edit_sku', [DatatablesController::class, 'editSKU'])->middleware('auth');
Route::delete('/delete_sku', [DatatablesController::class, 'deleteSKU'])->middleware('auth');
//line
Route::post('/line_list', [DatatablesController::class, 'lineList'])->middleware('auth');
Route::post('/add_line', [DatatablesController::class, 'addLine'])->middleware('auth');
Route::delete('/delete_line', [DatatablesController::class, 'deleteLine'])->middleware('auth');
//machine
Route::post('/machine_list', [DatatablesController::class, 'machineList'])->middleware('auth');
Route::post('/add_machine', [DatatablesController::class, 'addMachine'])->middleware('auth');
Route::delete('/delete_machine', [DatatablesController::class, 'deleteMachine'])->middleware('auth');
//shift
Route::post('/shift_list', [DatatablesController::class, 'shiftList'])->middleware('auth');
Route::post('/add_shift', [DatatablesController::class, 'addShift'])->middleware('auth');
Route::delete('/delete_shift', [DatatablesController::class, 'deleteShift'])->middleware('auth');
//log
Route::post('/historical_log', [DatatablesController::class, 'historicalLog'])->middleware('auth');
Route::post('/livedata_once', [DashboardController::class, 'liveDataOnce'])->middleware('auth');
Route::post('/livedata', [DashboardController::class, 'liveData'])->middleware('auth');
//account
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/account', [LoginController::class, 'showAccount'])->middleware('auth');
Route::post('/update_password', [LoginController::class, 'updatePassword'])->middleware('auth');
