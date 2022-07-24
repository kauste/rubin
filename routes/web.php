<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\FrontController;

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
Route::get('/', [FrontController::class, 'salons'])->name('front-salons')->middleware('role:user');
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

//front

Route::prefix('front')->name('front-')->middleware('role:user')->group(function () {
    Route::get('/salons', [FrontController::class, 'salons'])->name('salons');
    Route::get('/services', [FrontController::class, 'procedures'])->name('procedures');
    Route::get('/masters', [FrontController::class, 'masters'])->name('masters');
    Route::get('/salon/masters/{salon}', [FrontController::class, 'salonMasters'])->name('salon-masters');
    Route::get('/{salon}/{id}', [FrontController::class, 'salonMasterProcedures'])->name('salon-master');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
