<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
/*
Route::get('/test-db', function() {
    try {
        return response()->json([
            'status' => DB::connection()->getPdo() ? 'OK' : 'Error'
        ]);
    } catch (Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
});*/