<?php

namespace App\Core;

use App\Controllers\Frontend\HomeController;
use App\Controllers\Frontend\User\AuthController;

// Register routes
Route::add('home', HomeController::class, 'index');
Route::add('auth/logout', AuthController::class, 'logout');
Route::add('auth/login', AuthController::class, 'login');

$url = $_GET['url'] ?? 'home';

Route::handle($url);
