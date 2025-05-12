<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Contoh route API
Route::get('/test', function () {
    return response()->json(['message' => 'API route is working!']);
});