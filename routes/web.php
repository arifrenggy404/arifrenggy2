<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Models\Message;
use Illuminate\Http\Request;

Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects.index');
Route::get('/projects/{slug}', [PortfolioController::class, 'show'])->name('projects.show');
