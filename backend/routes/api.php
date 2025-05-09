<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadController;

// Public routes (no role restriction)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Role-based access control (admin, manager, employee)
Route::middleware('role:admin')->get('/admin-dashboard', function () {
    return 'Admin Dashboard';  // Accessible only to admin
});

Route::middleware('role:manager')->get('/manager-dashboard', function () {
    return 'Manager Dashboard';  // Accessible only to manager
});

Route::middleware('role:employee')->get('/employee-dashboard', function () {
    return 'Employee Dashboard';  // Accessible only to employee
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('leads', LeadController::class);
});

// Lead Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/leads', [LeadController::class, 'index']);
    Route::post('/leads', [LeadController::class, 'store']);
    Route::put('/leads/{lead}', [LeadController::class, 'update']);
    Route::delete('/leads/{lead}', [LeadController::class, 'destroy']);
});