<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\adminDomisiliController;
use App\Http\Controllers\adminSkckController;
use App\Http\Controllers\adminUmumController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\biodataController;
use App\Http\Controllers\skckController;
use App\Http\Controllers\wargaController;
use App\Http\Controllers\wargaDomisiliController;
use App\Http\Controllers\wargaSkckController;
use App\Http\Controllers\wargaUmumController;

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

Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login-show');
    Route::post('/', [AuthController::class, 'login'])->name('login');

    Route::get('/register', [registerController::class, 'index'])->name('register-show');
    Route::post('/createaccount', [registerController::class, 'store'])->name('create-account');
});


Route::middleware(['auth'])->group(function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |----------------------
    | Route Warga
    |----------------------
    */
    Route::middleware('warga')->group(function () {
        Route::prefix('dashboard')->name('dashboard-')->group(function () {
            Route::get('/', [wargaController::class, 'index'])->name('index');
        });

        Route::prefix('biodata')->name('biodata-')->group(function () {
            Route::get('/', [biodataController::class, 'index'])->name('index');
            Route::get('/create', [biodataController::class, 'create'])->name('create');
            Route::post('/store', [biodataController::class, 'store'])->name('store');
            Route::get('/biodata/{id}/edit', [biodataController::class, 'edit'])->name('edit');
            Route::post('/biodata/{id}/update', [biodataController::class, 'update'])->name('update');
        });

        Route::prefix('SKCK')->name('skck-')->group(function () {
            Route::get('/', [wargaSkckController::class, 'index'])->name('index');
            Route::get('/create', [wargaSkckController::class, 'create'])->name('create');
            Route::post('/store', [wargaSkckController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [wargaSkckController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [wargaSkckController::class, 'update'])->name('update');
        });

        Route::prefix('domisili')->name('domisili-')->group(function () {
            Route::get('/', [wargaDomisiliController::class, 'index'])->name('index');
            Route::get('/create', [wargaDomisiliController::class, 'create'])->name('create');
            Route::post('/store', [wargaDomisiliController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [wargaDomisiliController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [wargaDomisiliController::class, 'update'])->name('update');
        });

        Route::prefix('umum')->name('umum-')->group(function () {
            Route::get('/', [wargaUmumController::class, 'index'])->name('index');
            Route::get('/create', [wargaUmumController::class, 'create'])->name('create');
            Route::post('/store', [wargaUmumController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [wargaUmumController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [wargaUmumController::class, 'update'])->name('update');
        });
    });

    /*
    |----------------------
    | Route Admin
    |----------------------
    */
    Route::middleware('admin')->prefix('admin')->name('admin-')->group(function () {
        Route::prefix('dashboard')->name('dashboard-')->group(function () {
            Route::get('/', [adminController::class, 'index'])->name('index');
        });

        Route::prefix('SKCK')->name('skck-')->group(function () {
            Route::get('/', [adminSkckController::class, 'index'])->name('index');
            Route::get('/{id}', [adminSkckController::class, 'show'])->name('show');
            Route::post('/comment/{id}', [adminSkckController::class, 'comment'])->name('comment');
            Route::post('/approve/{id}', [adminSkckController::class, 'approve'])->name('approve');
            Route::post('/reject/{id}', [adminSkckController::class, 'reject'])->name('reject');
            Route::post('/revisi/{id}', [adminSkckController::class, 'revisi'])->name('revisi');
            Route::get('/pdf/{id}', [adminSkckController::class, 'pdf'])->name('pdf');
        });

        Route::prefix('domisili')->name('domisili-')->group(function () {
            Route::get('/', [adminDomisiliController::class, 'index'])->name('index');
            Route::get('/{id}', [adminDomisiliController::class, 'show'])->name('show');
            Route::post('/comment/{id}', [adminDomisiliController::class, 'comment'])->name('comment');
            Route::post('/approve/{id}', [adminDomisiliController::class, 'approve'])->name('approve');
            Route::post('/reject/{id}', [adminDomisiliController::class, 'reject'])->name('reject');
            Route::post('/revisi/{id}', [adminDomisiliController::class, 'revisi'])->name('revisi');
            Route::get('/pdf/{id}', [adminDomisiliController::class, 'pdf'])->name('pdf');
        });

        Route::prefix('umum')->name('umum-')->group(function () {
            Route::get('/', [adminUmumController::class, 'index'])->name('index');
            Route::get('/{id}', [adminUmumController::class, 'show'])->name('show');
            Route::post('/comment/{id}', [adminUmumController::class, 'comment'])->name('comment');
            Route::post('/approve/{id}', [adminUmumController::class, 'approve'])->name('approve');
            Route::post('/reject/{id}', [adminUmumController::class, 'reject'])->name('reject');
            Route::post('/revisi/{id}', [adminUmumController::class, 'revisi'])->name('revisi');
            Route::get('/pdf/{id}', [adminUmumController::class, 'pdf'])->name('pdf');
        });
    });
});
