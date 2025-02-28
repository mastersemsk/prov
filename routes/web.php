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

Route::get('/products/list',[ProductController::class,'index']);
Route::get('/products/create',[ProductController::class,'create']);
Route::post('/products/create',[ProductController::class,'store']);
Route::get('/products/edit/{id}',[ProductController::class,'edit'])->whereNumber('id');

Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->whereNumber('id');
