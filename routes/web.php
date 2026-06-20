<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Models\Message;
use Illuminate\Http\Request;

Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects.index');
Route::get('/projects/{slug}', [PortfolioController::class, 'show'])->name('projects.show');
Route::get('/contact', [PortfolioController::class, 'contact'])->name('contact');

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string',
    ]);

    Message::create($validated);

    return back()->with('success', 'Pesan Anda berhasil terkirim!');
})->name('contact.store');
