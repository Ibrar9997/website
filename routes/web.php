<?php

use Illuminate\Support\Facades\Route;

Route::get('/page-1', function () {
    return view('page-1');
});

Route::get('/page-2', function () {
    return view('page-2');
});
