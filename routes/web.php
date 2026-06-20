<?php

use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

// Main Scanner Route
Route::get('/', function () {
    try {
        $userAgent = request()->userAgent() ?? '';
        $device = 'Unknown Device';
        if (preg_match('/iphone/i', $userAgent)) {
            $device = 'iPhone';
        } elseif (preg_match('/ipad/i', $userAgent)) {
            $device = 'iPad';
        } elseif (preg_match('/android/i', $userAgent)) {
            $device = 'Android Device';
        } elseif (preg_match('/windows/i', $userAgent)) {
            $device = 'Windows PC';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $device = 'Mac';
        } elseif (preg_match('/linux/i', $userAgent)) {
            $device = 'Linux PC';
        }

        \App\Models\Visitor::create([
            'ip_address' => request()->ip(),
            'user_agent' => $userAgent,
            'device' => $device,
        ]);
    } catch (\Exception $e) {
        // Silently catch database errors during early migrations
    }

    return view('scanner');
});

// Upload API Endpoint (placed in web.php for CSRF integration)
Route::post('/api/uploads', [UploadController::class, 'store'])->name('api.uploads.store');

// Admin Dashboard Routes
Route::get('/admin', [UploadController::class, 'index'])->name('admin.dashboard');
Route::delete('/admin/uploads/{id}', [UploadController::class, 'destroy'])->name('admin.uploads.destroy');
