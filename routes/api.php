<?php

use App\Http\Controllers\Api\PasskeyController;
use Illuminate\Support\Facades\Route;

Route::get('/passkeys/register', [PasskeyController::class, 'registerOptions'])
    ->middleware('auth:sanctum');
