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

// Rotta per contare le visite ad un appartamento
Route::post('/apartments/views/', [ApartmentController::class, 'countViews']);

// Rotta per ottenere tutti i servizi
Route::get('/apartments/services', [ApartmentController::class, 'services']);

// Rotta per cercare gli appartamenti per indirizzo e distanza
Route::get('apartments/search/', [ApartmentController::class, 'search'])->name('apartments.search');

// Rotta per il dettaglio dell'appartamento
Route::get('/apartments/{slug}', [ApartmentController::class, 'show']);

//Rotta messaggi
Route::post('/contact-message/{apartment_id}', [ContactController::class, 'message']);
