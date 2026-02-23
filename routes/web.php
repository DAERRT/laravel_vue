<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login.login');

Route::get('/register', [RegisterController::class, 'index'])->name('register.show');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/logout', function () {
    Auth::logout();

    return redirect('/home');
})->name('logout');

Route::get('/admin', [AdminController::class, 'show'])->name('admin.show');

Route::post('/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete')->middleware('auth');

Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');

Route::post('/edit/save', [AdminController::class, 'save'])->name('admin.save');

Route::post('/edit/{id}/roles', [AdminController::class, 'updateRoles'])->name('admin.roles.update');

Route::get('/drop/{id}', [AdminController::class, 'dropPass'])->name('admin.drop');
