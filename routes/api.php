<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\EspeceController;
use App\Http\Controllers\ProprietaireController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PensionController;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\TarificationController;
use App\Http\Controllers\TypeGardiennageController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\ProprietaireAuthController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\TarifCatalogueController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes d'authentification admin
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Routes d'authentification propriétaire
Route::post('/proprietaire/login', [ProprietaireAuthController::class, 'login']);

// Routes protégées pour les propriétaires
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/proprietaire/profile', [ProprietaireAuthController::class, 'profile']);
    Route::post('/proprietaire/logout', [ProprietaireAuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    // Routes pour les animaux
    Route::get('/animals', [AnimalController::class, 'index']);
    Route::post('/animals', [AnimalController::class, 'store']);
    Route::get('/animals/{id}', [AnimalController::class, 'show']);
    Route::put('/animals/{id}', [AnimalController::class, 'update']);
    Route::delete('/animals/{id}', [AnimalController::class, 'destroy']);
    Route::get('/proprietaires/{id}/animals', [AnimalController::class, 'getByProprietaire']);

    // Routes pour les espèces
    Route::get('/especes', [EspeceController::class, 'index']);
    Route::post('/especes', [EspeceController::class, 'store']);
    Route::get('/especes/{id}', [EspeceController::class, 'show']);
    Route::put('/especes/{id}', [EspeceController::class, 'update']);
    Route::delete('/especes/{id}', [EspeceController::class, 'destroy']);

    // Routes pour les propriétaires
    Route::apiResource('proprietaires', ProprietaireController::class);
});

Route::apiResource('affectations', AffectationController::class);
Route::get('/affectations', [AffectationController::class, 'index']);
Route::get('/affectations/{id}', [AffectationController::class, 'show']);
Route::post('/affectations', [AffectationController::class, 'store']);
Route::put('/affectations/{id}', [AffectationController::class, 'update']);
Route::delete('/affectations/{id}', [AffectationController::class, 'destroy']);

Route::get('/pension', [PensionController::class, 'index']);
Route::get('/pension/{id}', [PensionController::class, 'show']);
Route::post('/pension', [PensionController::class, 'store']);
Route::put('/pension/{id}', [PensionController::class, 'update']);
Route::delete('/pension/{id}', [PensionController::class, 'destroy']);

Route::apiResource('boxes', BoxController::class);
Route::apiResource('tarification', TarificationController::class);
Route::apiResource('types-gardiennage', TypeGardiennageController::class);

Route::get('/utilisateurs', [UtilisateurController::class, 'index']);
Route::post('/utilisateurs', [UtilisateurController::class, 'store']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Routes pour les catalogues et tarifs (publiques)
Route::apiResource('catalogues', CatalogueController::class);
Route::apiResource('tarif-catalogues', TarifCatalogueController::class);
