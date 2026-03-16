<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RatingController;

Route::post('/rate', [RatingController::class, 'store'])->name('rate.article');

Route::view('/', 'welcome')->name('home');
