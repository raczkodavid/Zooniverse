<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\EnclosureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
});

Route::get('/dashboard', function () {
	return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin-specific routes
Route::middleware(['auth', 'admin'])->group(function () {
	Route::resource('enclosures', EnclosureController::class)->except(['index', 'show']);
	Route::resource('animals', AnimalController::class)->except(['index', 'show']);
	Route::get('animals/archived', [AnimalController::class, 'archived'])->name('animals.archived');
	Route::post('animals/{id}/restore', [AnimalController::class, 'restore'])->name('animals.restore');
});

// Routes available for all authenticated users (both admin and non-admin)
Route::middleware('auth')->group(function () {
	Route::get('/homepage', [HomeController::class, 'index'])->name('homepage');
	Route::resource('enclosures', EnclosureController::class)->only(['index', 'show']);

	// Profile routes
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
