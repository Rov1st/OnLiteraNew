<?php

// routes/api.php
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::get('/users', function () {
    return User::all();
});

