<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PredictionController; // ADDED: Import PredictionController
use App\Http\Controllers\AdminController; // ADDED: Import AdminController
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile'); // CHANGED: Use index for profile view
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit'); // ADDED: Separate route for edit
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/prediction', [PredictionController::class, 'index'])->name('prediction');
    Route::get('/predict', [PredictionController::class, 'index'])->name('predict.index'); 
    Route::post('/predict', [PredictionController::class, 'predict'])->name('predict');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin')->middleware('admin');
});

require __DIR__.'/auth.php';
