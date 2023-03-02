<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MechanicController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
