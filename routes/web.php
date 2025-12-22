<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authcontroller;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;


// ******page-1 route******
Route::get('/page-1', function () {
    return view('page-1');
});

// ******page-2 route******
Route::get('/page-2', function () {
    return view('page-2');
});

// ******Sign-up route******
Route::get('/register', function(){
    return view('auth/register');
});
Route::get('/register', [authcontroller::class, 'register']);


// ******Sign-in route******
Route::get('/login', function(){
    return view('auth/login');
});
Route::get('/', [authcontroller::class, 'login']);
