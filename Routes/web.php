<?php

use System\Route;
use App\Controller\Auth\LoginController;
use App\Controller\BackView\DashboardController;

/**
 * cargar el autoloader de composer Y la configuracion de la aplicacion
 */
require_once dirname(__DIR__) . '/System/Autoload.php';

//login
Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::post('/', [LoginController::class, 'store']);
Route::get('/admin', [LoginController::class, 'admin'])->name('login.admin');
Route::post('/admin', [LoginController::class, 'adminstore']);

Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');

//dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
