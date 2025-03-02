<?php
# web.php

namespace App\Core;

use App\Controllers\Frontend\HomeController;
use App\Controllers\Frontend\User\AuthController;
use App\Controllers\Frontend\Resume\DashboardController;

// Register routes
Route::add("home", HomeController::class, "index");
Route::add("auth/logout", AuthController::class, "logout");
Route::add("auth/login", AuthController::class, "login");
Route::add("auth/signup", AuthController::class, "signup");
Route::add("dashboard", DashboardController::class, "index");

$url = $_GET["url"] ?? "home";
Route::handle($url);

