<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\BookController;

Route::get('/api/books', [BookController::class,"index"]);
Route::post('/api/books',[BookController::class,"store"]);
Route::get('/api/books/{book}',[BookController::class,"show"]);
Route::put('/api/books/{book}',[BookController::class,"update"]);