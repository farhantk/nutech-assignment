<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return redirect('/signin');
});

// Auth
Route::get('/signin', [AuthController::class, 'view_signin'])
    ->middleware(['guest'])
    ->name('signin');
Route::post('/signin', [AuthController::class, 'action_signin'])
    ->middleware(['guest']);

Route::get('/signup', [AuthController::class, 'view_signup'])
    ->middleware(['guest'])
    ->name('signup');
Route::post('/signup', [AuthController::class, 'action_signup'])
    ->middleware(['guest']);

Route::get('/profile', [AuthController::class, 'view_profile'])
    ->middleware(['auth']);
Route::post('/signout', [AuthController::class, 'action_signout'])
    ->middleware(['auth']);




// Category 
Route::get('/category', [CategoryController::class, 'view_category'])
    ->middleware(['auth'])
    ->name('category');
Route::post('/category', [CategoryController::class, 'action_addCategory'])
    ->middleware(['auth']);
Route::put('/category/{id}', [CategoryController::class, 'action_edit'])
    ->middleware(['auth']);
Route::delete('/category/{id}', [CategoryController::class, 'action_destroy'])
    ->middleware(['auth']);


// Product
Route::get('/product', [ProductController::class, 'view_product'])
    ->middleware(['auth'])
    ->name('product');
Route::post('/product', [ProductController::class, 'action_addProduct'])
    ->middleware(['auth']);
Route::put('/product/{id}', [ProductController::class, 'action_editProduct'])
    ->middleware(['auth']);
Route::delete('/product/{id}', [ProductController::class, 'action_destroy'])
    ->middleware(['auth']);
