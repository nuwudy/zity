<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SuggestionsController;
use App\Http\Controllers\ZityCardController;

// Public Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/api/suggestions', [SuggestionsController::class, 'index'])->name('api.suggestions');

// Auth Routes (Username / Email / Phone + Password, Bot Protection & Guest-Friendly)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/complete-profile', [AuthController::class, 'completeProfile'])->name('profile.complete');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// User Profile & Hybrid Business Mode Routes (Auth Protected)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/my-businesses', [ProfileController::class, 'myBusinesses'])->name('profile.businesses');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/api/save-deal', [ProfileController::class, 'toggleSaveDeal'])->name('deal.save');
    Route::post('/api/unlock-deal', [ProfileController::class, 'unlockDeal'])->name('deal.unlock');
});

// Merchant Registration & Onboarding
Route::get('/check-availability', [HomeController::class, 'checkAvailability'])->name('check.availability');
Route::get('/register-shop', function () { return redirect('/#register-business'); });
Route::post('/register-shop', [HomeController::class, 'registerShop'])->name('register.shop');
Route::get('/register-success/{slug}', [HomeController::class, 'registerSuccess'])->name('register.success');

// System Utility
Route::get('/fix-storage', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'Storage link fixed successfully! <br><a href="/">Go back home</a>';
});

// Wildcard public digital card route
Route::get('/{slug}', [ZityCardController::class, 'show'])
    ->where('slug', '^(?!admin|api|livewire|storage|build|_debugbar|login|register|profile|my-businesses|complete-profile|search|logout|fix-storage).*$')
    ->name('card.show');
