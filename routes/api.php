<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Public API for migrating the IndexedDB-like storage to Laravel
use App\Http\Controllers\Api\TodoListController;
use App\Http\Controllers\Api\RepeatingEventController;
use App\Http\Controllers\Api\RepeatingEventByDateController;

// Rutas públicas (No requieren token)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login/external/{user_id}/{token}', [AuthController::class, 'loginByIntranet']);

// Rutas protegidas (Requieren token Bearer válido)
Route::middleware('auth:sanctum')->group(function () {
    
    // Obtener los datos del usuario logueado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/todo-lists', [TodoListController::class, 'index']);
    Route::get('/todo-lists/{id}', [TodoListController::class, 'show']);
    Route::post('/todo-lists', [TodoListController::class, 'store']);
    Route::put('/todo-lists/{id}', [TodoListController::class, 'update']);
    Route::delete('/todo-lists/{id}', [TodoListController::class, 'destroy']);
    Route::delete('/todo-lists', [TodoListController::class, 'clear']);

    Route::get('/repeating-events', [RepeatingEventController::class, 'index']);
    Route::get('/repeating-events/{id}', [RepeatingEventController::class, 'show']);
    Route::post('/repeating-events', [RepeatingEventController::class, 'store']);
    Route::put('/repeating-events/{id}', [RepeatingEventController::class, 'update']);
    Route::delete('/repeating-events/{id}', [RepeatingEventController::class, 'destroy']);
    Route::delete('/repeating-events', [RepeatingEventController::class, 'clear']);

    Route::get('/repeating-events-by-date', [RepeatingEventByDateController::class, 'index']);
    Route::get('/repeating-events-by-date/{date}', [RepeatingEventByDateController::class, 'show']);
    Route::put('/repeating-events-by-date/{date}', [RepeatingEventByDateController::class, 'update']);
    Route::delete('/repeating-events-by-date/{date}', [RepeatingEventByDateController::class, 'destroy']);
    Route::delete('/repeating-events-by-date', [RepeatingEventByDateController::class, 'clear']);

    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout']);
});


