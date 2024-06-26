<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

use Inertia\Inertia;

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
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('notes', NoteController::class)
    ->only(['index','store','create','edit','destroy','show']);

Route::post('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
//Route::put('/notes/update-tag-end', [NoteController::class, 'updateTagEnd']);  //Api Route
Route::put('/notes/update-tag-end', [NoteController::class, 'updateTagEnd'])->name('notes.update-tag-end');


require __DIR__.'/auth.php';



