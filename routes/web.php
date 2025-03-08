<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {return view('visitor.home');});

Route::get('/about', function () {return view('about');});