<?php

use App\Http\Controllers\AnimalFeedController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\CaregiverController;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Ruta para obtener todos los animales
Route::get('/categories', [CategoryController::class, 'get']);
Route::post('/categories', [CategoryController::class, 'store']); // para crear un nuevo animal
Route::get('/categories/{id}', [CategoryController::class, 'show']); // para obtener un animal específico
Route::put('/categories/{id}', [CategoryController::class, 'update']); // para actualizar un animal específico
Route::delete('/categories/{id}', [CategoryController::class, 'delete']); // para eliminar un animal específico
// Ruta para obtener todos los animales
Route::get('/animals', [AnimalController::class, 'get']);
Route::post('/animals', [AnimalController::class, 'store']); // para crear un nuevo animal
Route::get('/animals/{id}', [AnimalController::class, 'show']); // para obtener un animal específico
Route::put('/animals/{id}', [AnimalController::class, 'update']); // para actualizar un animal específico
Route::delete('/animals/{id}', [AnimalController::class, 'delete']); // para eliminar un animal específico
// // Rutas para CaregiverController
Route::get('/caregivers', [CaregiverController::class, 'get']);
Route::post('/caregivers', [CaregiverController::class, 'store']); // para crear un nuevo animal
Route::get('/caregivers/{id}', [CaregiverController::class, 'show']); // para obtener un animal específico
Route::put('/caregivers/{id}', [CaregiverController::class, 'update']); // para actualizar un animal específico
Route::delete('/caregivers/{id}', [CaregiverController::class, 'delete']); // para eliminar un animal específico
// // Rutas para AnimalFeedController
Route::post('/animals.feed', [AnimalFeedController::class, 'store']); // para crear un nuevo animal