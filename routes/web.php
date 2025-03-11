<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/property/{id}', [PropertyController::class, 'show'])->name('property.show');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/search', [SearchController::class, 'search'])->name('search.index');

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');

Route::post('/bookmark', [BookmarkController::class, 'store'])->name('bookmarks.store')->middleware('auth');

Route::get('/properties/create', [PropertyController::class, 'create'])->middleware('auth')->name('property.create');
Route::post('/properties', [PropertyController::class, 'store'])->middleware('auth')->name('property.store');

Route::get('/property/{id}/compare', [CompareController::class, 'show'])->name('property.compare');

Route::match(['get', 'post'], '/estimate', [EstimateController::class, 'index'])->name('estimate');

Route::get('/compare/update/{id}', [CompareController::class, 'updateComparison'])->name('compare.update');

Route::get('/search/results', [SearchController::class, 'showResults'])->name('search.results');

Route::post('/property/store', [PropertyController::class, 'store'])->middleware('auth')->name('property.store');
