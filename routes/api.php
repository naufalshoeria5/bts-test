<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductItemController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// * Authenticate

// Login
Route::post('login', [AuthController::class, 'login']);

// Register
Route::post('register', [AuthController::class, 'register']);

Route::get('check-data-user', function () {
    return User::all();
});

Route::group([
    'middleware' => ['auth:api'],
], function () {

    // * Checklist
    Route::post('checklist', [ProductController::class, 'store']);
    Route::get('checklist', [ProductController::class, 'index']);
    Route::delete('checklist/{id}', [ProductController::class, 'destroy']);

    // * Checklist Item
    Route::get('checklist/{id}/item', [ProductItemController::class, 'index']);
    Route::get('checklist/{id}/item/{itemId}', [ProductItemController::class, 'show']);
    Route::post('checklist/{id}/item', [ProductItemController::class, 'store']);
    Route::delete('checklist/{id}/item/{itemId}', [ProductItemController::class, 'destroy']);
    Route::put('checklist/{id}/item/rename/{itemId}', [ProductItemController::class, 'rename']);
});
