<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderDocTypeController;
use App\Http\Controllers\OrdersDetailController;
use App\Http\Controllers\ClientDocTypeController;

Route::prefix('api')->group( function (){

  Route::controller( BookController::class )->group( function(){
    Route::get('/books',"index");
    Route::post('/books',"store");
    Route::get('/books/{name}',"show");
    Route::get('/books/{isbn}',"show");
    Route::put('/books/{isbn}',"update");
    Route::delete('/books/{isbn}',"destroy");
  } );

  Route::controller( ClientDocTypeController::class )->group( function(){
    Route::get("/clients/doctypes","index");
    Route::post("/clients/doctypes","store");
    Route::get("/clients/doctypes/{cdt}","show");
    Route::put("/clients/doctypes/{cdt}","update");
    Route::delete("/clients/doctypes/{cdt}","destroy");
  } );

  Route::controller( OrderDocTypeController::class )->group( function(){
    Route::get("/orders/doctypes","index");
    Route::post("/orders/doctypes","store");
    Route::get("/orders/doctypes/{cdt}","show");
    Route::put("/orders/doctypes/{cdt}","update");
    Route::delete("/orders/doctypes/{cdt}","destroy");
  } );

  Route::controller( ClientController::class )->group( function(){
    Route::get("/clients","index");
    Route::post("/clients","store");
    Route::get("/clients/{client}","show");
    Route::put("/clients/{client}","update");
    Route::delete("/clients/{client}","destroy");
  } );

  Route::controller( OrderController::class )->group( function(){
    Route::get("/orders","index");
    Route::post("/orders","store");
    Route::get("/orders/{order}","show");
    Route::put("/orders/{order}","update");
    Route::delete("/orders/{order}","destroy");
  } );

  Route::controller( OrdersDetailController::class )->group( function(){
    Route::get("/details","index");
    Route::post("/details","store");
    Route::get("/details/{detail_id}","show");
    Route::put("/details/{detail_id}","update");
    Route::delete("/details/{detail_id}","destroy");
  } );

  Route::controller( SaleController::class )->group( function(){
    Route::post("/sale/generate","generate");
  } );

} );