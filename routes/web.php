<?php

use App\Http\Controllers\TicketsController;
use App\Http\Controllers\ShareController;
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

Route::get('/tickets', [TicketsController::class, 'index'])->middleware(['auth', 'verified'])->name('tickets');
Route::get('/get-tickets', [TicketsController::class, 'getTickets'])->middleware(['auth', 'verified'])->name('getTickets');
Route::get('/get-ticket', [TicketsController::class, 'show'])->middleware(['auth', 'verified'])->name('getTicket');
Route::post('/tickets', [TicketsController::class, 'store'])->middleware(['auth', 'verified'])->name('ticketCreate');
Route::put('/tickets', [TicketsController::class, 'update'])->middleware(['auth', 'verified'])->name('ticketUpdate');
Route::delete('/tickets', [TicketsController::class, 'destroy'])->middleware(['auth', 'verified'])->name('ticketDelete');

Route::post('/tickets-share', [TicketsController::class, 'share'])->middleware(['auth', 'verified'])->name('ticketShare');

Route::get('/shared', [ShareController::class, 'index'])->middleware(['auth', 'verified'])->name('shared');


require __DIR__.'/auth.php';
