<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\ProductController;

Route::post('/product',[ProductController::class,'store']);
Route::get('/product',[ProductController::class,'showAll']);
Route::get('/product/{id}',[ProductController::class,'showById']);
Route::get('/product/search/product_name={product_name}', [ProductController::class,'ShowByName']);
Route::put('/product/{id}',[ProductController::class,'update']);
Route::delete('/product/{id}',[ProductController::class,'delete']);