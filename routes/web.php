<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\ProcedureController;

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
Route::get('/salons', [SalonController::class, 'index'])->name('salons-index');
Route::get('/salons/create', [SalonController::class, 'create'])->name('salons-create');
Route::post('/salons/store', [SalonController::class, 'store'])->name('salons-store');
Route::get('/salons/edit/{salon}', [SalonController::class, 'edit'])->name('salons-edit');
Route::put('/salons/update/{salon}', [SalonController::class, 'update'])->name('salons-update');
Route::delete('/salons/delete/{salon}', [SalonController::class, 'destroy'])->name('salons-delete');

//paslaugos
Route::get('/services', [ProcedureController::class, 'index'])->name('procedures-index');
Route::get('/services/create', [ProcedureController::class, 'create'])->name('procedures-create');
Route::post('/services/store', [ProcedureController::class, 'store'])->name('procedures-store');
Route::get('/services/edit/{procedure}', [ProcedureController::class, 'edit'])->name('procedures-edit');
Route::put('/services/update/{procedure}', [ProcedureController::class, 'update'])->name('procedures-update');
Route::delete('/services/delete/{procedure}}', [ProcedureController::class, 'destroy'])->name('procedures-delete');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
