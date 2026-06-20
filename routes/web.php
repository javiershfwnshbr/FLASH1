<?php

use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

// Main Scanner Route
Route::get('/', function () {
    return view('scanner');
});

// Upload API Endpoint (placed in web.php for CSRF integration)
Route::post('/api/uploads', [UploadController::class, 'store'])->name('api.uploads.store');

// Admin Dashboard Routes
Route::get('/admin', [UploadController::class, 'index'])->name('admin.dashboard');
Route::delete('/admin/uploads/{id}', [UploadController::class, 'destroy'])->name('admin.uploads.destroy');
