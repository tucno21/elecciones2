<?php

use System\Route;
use App\Controller\Auth\LoginController;
use App\Controller\BackView\RolController;
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

//roles
Route::get('/roles', [RolController::class, 'index'])->name('roles.index');
Route::get('/roles/create', [RolController::class, 'create'])->name('roles.create');
Route::post('/roles/create', [RolController::class, 'store']);
Route::get('/roles/edit', [RolController::class, 'edit'])->name('roles.edit');
Route::post('/roles/edit', [RolController::class, 'update']);
Route::get('/roles/destroy', [RolController::class, 'destroy'])->name('roles.destroy');
