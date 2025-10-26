<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('startedPage');
})->name('started');

Route::get('/home', function () {
    return view('home');
})->name('home');
