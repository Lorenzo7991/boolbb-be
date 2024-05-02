<?php

use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\API\ContactController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::apiResource('apartments', ApartmentController::class)->only('index');
Route::get('/apartments/services', [ApartmentController::class, 'services']);


Route::get('apartments/search/', [ApartmentController::class, 'search'])->name('apartments.search');

Route::get('/apartments/{slug}', [ApartmentController::class, 'show']);

//Rotta messaggi
Route::post('/contact-message', [ContactController::class, 'message']);
