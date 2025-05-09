<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Define the route for the home page.
Route::get('/', function () {
    return view('home');
})->name('home');

// Define the route for the about page.
Route::get('/about', function () {
    return view('about');
})->name('about');

// Define the route for the contact page.
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Group routes that require user authentication
Route::middleware('auth')->group(function () {
    // Define routes for user profile management.
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Group routes that require user authentication, specifically for prediction and admin.
Route::middleware(['auth'])->group(function () {
    Route::get('/prediction', [PredictionController::class, 'index'])->name('prediction');
    Route::get('/predict', [PredictionController::class, 'index'])->name('predict.index');
    Route::post('/predict', [PredictionController::class, 'predict'])->name('predict');
    // Define the route for the admin dashboard.
    // This route should ideally be protected by an additional admin middleware
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin');
});

// Include authentication routes provided by Laravel Breeze/Jetstream.
require __DIR__ . '/auth.php';
