<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SuggestionsController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/suggestions', [SuggestionsController::class, 'index'])->name('api.suggestions');

Route::get('/check-availability', [HomeController::class, 'checkAvailability'])->name('check.availability');
Route::get('/register-shop', function () { return redirect('/'); });
Route::post('/register-shop', [HomeController::class, 'registerShop'])->name('register.shop');
Route::get('/register-success/{slug}', [HomeController::class, 'registerSuccess'])->name('register.success');
Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

// Place wildcard route at the very end
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/fix-storage', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'Storage link fixed successfully! <br><a href="/">Go back home</a>';
});
Route::get('/{business:slug}', [BusinessController::class, 'show'])
    ->where('business', '^(?!admin|api|livewire|storage|build|_debugbar).*$')
    ->name('business.show');
