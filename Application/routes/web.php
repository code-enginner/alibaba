<?php

use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Modules\Dashboard\App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', static function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->middleware('verified')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('articles', ArticleController::class);
});

Route::middleware('auth:admin')->group(function () {
    Route::post('approve/article', [ArticleController::class, 'approveArticle'])->name('approve.article');
});


require __DIR__ . '/auth.php';
