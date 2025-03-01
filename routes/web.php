<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/products/list',[ProductController::class,'index'])->name('prod_list');
Route::get('/products/create',[ProductController::class,'create'])->name('prod_create');
Route::put('/products/create',[ProductController::class,'store'])->name('prod_store');
Route::post('/products/edit/{id}',[ProductController::class,'edit'])->whereNumber('id')->name('prod_edit');
Route::put('/products/edit',[ProductController::class,'update'])->name('prod_update');
Route::get('/products/show/{id}',[ProductController::class,'show'])->whereNumber('id')->name('prod_show');
Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->whereNumber('id')->name('prod_remove');
