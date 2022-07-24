<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\MasterController;

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

Route::get('/welcome', function () {
    return view('welcome');
});
//salonai
Route::prefix('salons')->name('salons-')->middleware('role:admin')->group(function () {
    Route::get('/', [SalonController::class, 'index'])->name('index');
    Route::get('/create', [SalonController::class, 'create'])->name('create');
    Route::post('/store', [SalonController::class, 'store'])->name('store');
    Route::get('/edit/{salon}', [SalonController::class, 'edit'])->name('edit');
    Route::put('/update/{salon}', [SalonController::class, 'update'])->name('update');
    Route::delete('/delete/{salon}', [SalonController::class, 'destroy'])->name('delete');
});
//paslaugos
Route::prefix('services')->name('procedures-')->middleware('role:admin')->group(function () {
    Route::get('', [ProcedureController::class, 'index'])->name('index');
    Route::get('/create', [ProcedureController::class, 'create'])->name('create');
    Route::post('/store', [ProcedureController::class, 'store'])->name('store');
    Route::get('/edit/{procedure}', [ProcedureController::class, 'edit'])->name('edit');
    Route::put('/update/{procedure}', [ProcedureController::class, 'update'])->name('update');
    Route::delete('/delete/{procedure}}', [ProcedureController::class, 'destroy'])->name('delete');
});
//meistrai
Route::prefix('masters')->name('masters-')->middleware('role:admin')->group(function () {
    Route::get('/', [MasterController::class, 'index'])->name('index');
    Route::get('/create', [MasterController::class, 'create'])->name('create');
    Route::post('/store', [MasterController::class, 'store'])->name('store');
    Route::get('/edit/{master}', [MasterController::class, 'edit'])->name('edit');
    Route::put('/update/{master}', [MasterController::class, 'update'])->name('update');
    Route::delete('/delete/{master}}', [MasterController::class, 'destroy'])->name('delete');
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
