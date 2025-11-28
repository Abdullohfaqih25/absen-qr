<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Login routes
Route::get('login', 'Illuminate\Foundation\Auth\AuthenticatesUsers@showLoginForm')->name('login');
Route::post('login', 'Illuminate\Foundation\Auth\AuthenticatesUsers@login');
Route::post('logout', 'Illuminate\Foundation\Auth\AuthenticatesUsers@logout')->name('logout');

// Redirect if authenticated
Route::redirect('/', 'login');
