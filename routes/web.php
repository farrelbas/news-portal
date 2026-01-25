<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\NewsCategoryController;

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
    return view('Public/Dashboard/dashboard');
});

// Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/check_login', [AuthController::class, 'check_login'])->name('check_login');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register-store', [AuthController::class, 'register_store'])->name('register-store');

Route::middleware(['auth.session'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/level', [LevelController::class, 'index'])->name('level');
    Route::post('/level/store', [LevelController::class, 'store'])->name('level.store');
    Route::post('/level/delete', [LevelController::class, 'delete'])->name('level.delete');

    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/user/delete', [UserController::class, 'delete'])->name('user.delete');



    Route::get('/news-category', [NewsCategoryController::class, 'index'])->name('news-category');
    Route::post('/news-category/store', [NewsCategoryController::class, 'store'])->name('news-category.store');
    Route::post('/news-category/delete', [NewsCategoryController::class, 'delete'])->name('news-category.delete');

    Route::get('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
