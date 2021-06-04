<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifyController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'number_verified'])->name('dashboard');

Route::get('/userpage', function () {
    return Inertia::render('User');
})->middleware(['auth', 'number_verified', 'verified'])->name('user');

Route::get('/user', [UserController::class, 'User']);

Route::get('/verify', [VerifyController::class, 'getVerify'])->name('getverify');
Route::post('/verify', [VerifyController::class, 'postVerify'])->name('verify');

require __DIR__.'/auth.php';
