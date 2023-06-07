<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CallendarController;
use App\Http\Controllers\ApointmentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TaskController;


use App\Models\Comment;

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
Route::get('/', [TaskController::class, 'index'])->name('task');
//mail
Route::post('/mail', [TaskController::class, 'mail'])->name('mail');


//Login

Route::get('/hello/{master}', function()
{
    return View::make('front.comments.index', ['comments'=> Comment::all(), 'master' =>$master]);
});
//salonai
Route::prefix('salons')->name('salons-')->middleware(['role:admin'])->group(function () {
    Route::get('/', [SalonController::class, 'index'])->name('index');
    Route::get('/create', [SalonController::class, 'create'])->name('create');
    Route::post('/store', [SalonController::class, 'store'])->name('store');
    Route::get('/edit/{salon}', [SalonController::class, 'edit'])->name('edit');
    Route::put('/update/{salon}', [SalonController::class, 'update'])->name('update');
    Route::delete('/delete/{salon}', [SalonController::class, 'destroy'])->name('delete');
});
//paslaugos
Route::prefix('services')->name('procedures-')->middleware(['role:admin'])->group(function () {
    Route::get('', [ProcedureController::class, 'index'])->name('index');
    Route::get('/create', [ProcedureController::class, 'create'])->name('create');
    Route::post('/store', [ProcedureController::class, 'store'])->name('store');
    Route::get('/edit/{procedure}', [ProcedureController::class, 'edit'])->name('edit');
    Route::put('/update/{procedure}', [ProcedureController::class, 'update'])->name('update');
    Route::delete('/delete/{procedure}}', [ProcedureController::class, 'destroy'])->name('delete');
});
//meistrai
Route::prefix('masters')->name('masters-')->middleware(['role:admin'])->group(function () {
    Route::get('/', [MasterController::class, 'index'])->name('index');
    Route::get('/create', [MasterController::class, 'create'])->name('create');
    Route::post('/store', [MasterController::class, 'store'])->name('store');
    Route::get('/edit/{master}', [MasterController::class, 'edit'])->name('edit');
    Route::put('/update/{master}', [MasterController::class, 'update'])->name('update');
    Route::delete('/delete/{master}}', [MasterController::class, 'destroy'])->name('delete');
});
//orderiai
Route::prefix('back')->name('back-')->middleware(['role:admin'])->group(function () {
    Route::get('confirmed-orders', [ApointmentController::class, 'backConfirmedOrders'])->name('confirmed-orders');
    Route::post('change-state/{id}', [ApointmentController::class, 'backChangeState'])->name('change-state');
    Route::delete('cliend-canceled-seen/{id}', [ApointmentController::class, 'backClientCanceledSeen'])->name('cliend-canceled-seen');
});

//front
Route::prefix('front')->name('front-')->middleware(['role:user'])->group(function () {
    Route::get('confirmed-orders', [ApointmentController::class, 'confirmedOrders'])->name('confirmed-orders');
    Route::post('comment-store/{id}', [CommentController::class, 'store'])->name('comment-store');
    Route::post('rate', [RatingController::class, 'rate'])->name('rate');
    Route::get('my-order', [ApointmentController::class, 'showMyOrder'])->name('my-order');
    Route::delete('client-delete-appointment/{id}', [ApointmentController::class, 'clientDeleteAppointment'])->name('client-delete-appointment');
});

Route::prefix('front')->name('front-')->middleware(['role:user,guest'])->group(function () {            
    Route::get('salons', [FrontController::class, 'salons'])->name('salons');
    Route::get('services', [FrontController::class, 'procedures'])->name('procedures');
    Route::get('masters', [FrontController::class, 'masters'])->name('masters');
    Route::get('salon/masters/{id}', [FrontController::class, 'salonMasters'])->name('salon-masters');
    Route::get('{id}/{date?}', [FrontController::class, 'salonMasterProcedures'])->name('salon-master');
    Route::get('comments/list/{id}', [CommentController::class, 'index'])->name('comments-list');
    Route::post('change-state/{id}', [ApointmentController::class, 'frontChangeState'])->name('change-state');
    Route::delete('changed-state-seen/{id}', [ApointmentController::class, 'frontChangedStateSeen'])->name('changed-state-seen');
});


//for javascript
Route::post('next-month/', [CallendarController::class, 'nextMonth'])->name('next-month');
Route::post('previous-month/', [CallendarController::class, 'previousMonth'])->name('previous-month');
Route::post('day', [CallendarController::class, 'showDay'])->name('show-day');

Route::middleware(['role:user'])->group(function () {
Route::post('add-to-cart', [ApointmentController::class, 'addToCart'])->name('add-to-cart');
Route::put('update-to-cart', [ApointmentController::class, 'updateToCart'])->name('update-to-cart');
Route::get('show-nav-cart', [ApointmentController::class, 'showNavCart'])->name('show-nav-cart');
Route::post('make-order', [ApointmentController::class, 'store'])->name('make-order');
});

Auth::routes(['register'=>false]);
// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('')->middleware('role:user');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('')->middleware('role:user');

