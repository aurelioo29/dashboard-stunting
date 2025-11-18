<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostApiController; // <-- TAMBAH INI

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
| Route yang bisa diakses tanpa login (guest).
| Dipakai untuk register dan login dari Flutter.
*/

Route::get('/ping', function () {
    return response()->json([
        'success' => true,
        'message' => 'API e-Stunt aktif 🚀',
    ]);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Public Post Routes (untuk Flutter Home / Edukasi)
|--------------------------------------------------------------------------
| Route ini tidak butuh login, jadi orang tua bisa baca artikel tanpa login.
| Kalau mau wajib login, nanti bisa dipindah ke dalam group auth:sanctum.
*/

Route::get('/posts',        [PostApiController::class, 'index']);
Route::get('/posts/{slug}', [PostApiController::class, 'show'])
    ->where('slug', '.*'); // kalau slug-nya ada strip / karakter khusus

/*
|--------------------------------------------------------------------------
| Protected API Routes (auth:sanctum)
|--------------------------------------------------------------------------
| Semua route di dalam group ini butuh Bearer Token dari Sanctum.
*/

Route::middleware('auth:sanctum')->group(function () {

    // --- Info user yang sedang login ---
    Route::get('/me', function (Request $request) {
        return response()->json([
            'success' => true,
            'data'    => $request->user(),
        ]);
    });

    // --- Logout (hapus token aktif) ---
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | Route khusus ADMIN (Dashboard Web)
    |--------------------------------------------------------------------------
    | Hanya role = 'admin' yang boleh akses.
    | Token admin bisa dipakai untuk API dashboard, monitoring, dll.
    */

    Route::middleware('role:admin')->group(function () {

        // Contoh endpoint data statistik dashboard
        Route::get('/admin/dashboard-stats', function () {
            return response()->json([
                'success' => true,
                'message' => 'Data khusus admin',
                'data' => [
                    'total_users'  => \App\Models\User::count(),
                    'timestamp'    => now()->toDateTimeString(),
                ],
            ]);
        });

        // Di sini nanti kamu bisa tambah route lain khusus admin, misal:
        // Route::get('/admin/users', [AdminUserController::class, 'index']);
    });

    /*
    |--------------------------------------------------------------------------
    | Route khusus USER (Flutter / Orang Tua)
    |--------------------------------------------------------------------------
    | Hanya role = 'user' yang boleh akses.
    | Di sini tempat endpoint untuk aplikasi mobile e-Stunting.
    */

    Route::middleware('role:user')->group(function () {

        // Contoh: profile user (orang tua)
        Route::get('/user/profile', function (Request $request) {
            return response()->json([
                'success' => true,
                'data'    => $request->user(),
            ]);
        });

        // Nanti di sini kamu buat:
        // Route::get('/anak', [AnakController::class, 'index']);
        // Route::post('/prediksi', [PrediksiController::class, 'store']);
        // dst.
    });
});
