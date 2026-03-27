<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticlesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function (){
    return redirect()->route('home');
});
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

Route::get('/roles', [AdminController::class, 'showRoles'])->name('admin.roles');


Route::get('/profile',[ProfileController::class, 'showProfile'])->name('profile.show');

Route::post('/profile/delete', [ProfileController::class, 'delete'])->name('profile.delete');

Route::get('/profile/edit',[ProfileController::class, 'showEditProfile'])->name('profile.edit.show');
Route::post('/profile/edit',[ProfileController::class, 'storeEditProfile'])->name('profile.edit.store');

Route::get('/profile/change-password',[ProfileController::class, 'showChangePass'])->name('profile.edit.show');
Route::post('/profile/change-password',[ProfileController::class, 'storeChangePass'])->name('profile.edit.store');


Route::get('/articles', [ArticlesController::class, 'index'])->name('articles.index');

Route::get('/articles/create', [ArticlesController::class, 'showCreate'])->name('articles.create.show');
Route::post('/articles/create', [ArticlesController::class, 'storeArticle'])->name('articles.create.store');

Route::get('/articles/{id}', [ArticlesController::class, 'showArticle'])->name('articles.article.show');

Route::delete('/articles/{id}/delete', [ArticlesController::class, 'deleteArticle'])->name('articles.article.delete');

Route::get('/articles/{id}/like',[ArticlesController::class,'like'])->name('articles.like');
Route::get('/articles/{id}/dislike', [ArticlesController::class,'dislike'])->name('articles.dislike');

Route::get('/articles/{id}/edit',[ArticlesController::class,'showEdit'])->name('articles.edit.show');
Route::post('/articles/{id}/edit',[ArticlesController::class,'storeEdit'])->name('articles.edit.store');


// Route::get('/createRoles', [AdminController::class,'createRoles'])->name('admin.roles.create');  
