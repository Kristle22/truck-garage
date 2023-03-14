<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\TruckController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'mechanics'], function(){
    Route::get('', [MechanicController::class, 'index'])->name('mechanic.index');
    Route::get('create', [MechanicController::class, 'create'])->name('mechanic.create');
    Route::post('store', [MechanicController::class, 'store'])->name('mechanic.store');
    Route::get('edit/{mechanic}', [MechanicController::class, 'edit'])->name('mechanic.edit');
    Route::post('update/{mechanic}', [MechanicController::class, 'update'])->name('mechanic.update');
    Route::post('delete/{mechanic}', [MechanicController::class, 'destroy'])->name('mechanic.destroy');
    Route::get('show/{mechanic}', [MechanicController::class, 'show'])->name('mechanic.show');
 });

 Route::group(['prefix' => 'trucks'], function(){
    Route::get('', [TruckController::class, 'index'])->name('truck.index');
    Route::get('create', [TruckController::class, 'create'])->name('truck.create');
    Route::post('store', [TruckController::class, 'store'])->name('truck.store');
    Route::get('edit/{truck}', [TruckController::class, 'edit'])->name('truck.edit');
    Route::post('update/{truck}', [TruckController::class, 'update'])->name('truck.update');
    Route::post('delete/{truck}', [TruckController::class, 'destroy'])->name('truck.destroy');
    Route::get('show/{truck}', [TruckController::class, 'show'])->name('truck.show');

    Route::get('pdf/{truck}', [TruckController::class, 'pdf'])->name('truck.pdf');

 });

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
