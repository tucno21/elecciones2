<?php

use System\Route;
use App\Controller\Auth\LoginController;
use App\Controller\BackView\RolController;
use App\Controller\BackView\UserController;
use App\Controller\BackView\SchoolController;
use App\Controller\BackView\StudentController;
use App\Controller\BackView\DashboardController;
use App\Controller\BackView\PermissionController;
use App\Controller\BackView\VotingGroupController;
use App\Controller\BackView\RolesPermissionController;

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

//permisos
Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
Route::post('/permissions/create', [PermissionController::class, 'store']);
Route::get('/permissions/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
Route::post('/permissions/edit', [PermissionController::class, 'update']);
Route::get('/permissions/destroy', [PermissionController::class, 'destroy'])->name('permissions.destroy');

//schools
Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
Route::get('/schools/create', [SchoolController::class, 'create'])->name('schools.create');
Route::post('/schools/create', [SchoolController::class, 'store']);
Route::get('/schools/edit', [SchoolController::class, 'edit'])->name('schools.edit');
Route::post('/schools/edit', [SchoolController::class, 'update']);
Route::get('/schools/destroy', [SchoolController::class, 'destroy'])->name('schools.destroy');
Route::get('/myschool', [SchoolController::class, 'myschool'])->name('schools.myschool');

//usuarios
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/create', [UserController::class, 'store']);
Route::get('/users/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users/edit', [UserController::class, 'update']);
Route::get('/users/destroy', [UserController::class, 'destroy'])->name('users.destroy');

//role y permisos
Route::get('/roles_permissions', [RolesPermissionController::class, 'edit'])->name('roles.permissions');
Route::post('/roles_permissions', [RolesPermissionController::class, 'update']);

//votinggroups
Route::get('/votinggroups', [VotingGroupController::class, 'index'])->name('votinggroups.index');
Route::get('/votinggroups/create', [VotingGroupController::class, 'create'])->name('votinggroups.create');
Route::post('/votinggroups/create', [VotingGroupController::class, 'store']);
Route::get('/votinggroups/destroy', [VotingGroupController::class, 'destroy'])->name('votinggroups.destroy');

//students
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/students/create', [StudentController::class, 'store']);
Route::get('/students/destroy', [StudentController::class, 'destroy'])->name('students.destroy');

Route::get('/students/tablemodel', [StudentController::class, 'tablemodel'])->name('students.tablemodel');
Route::get('/students/uploaddata', [StudentController::class, 'uploaddata'])->name('students.uploaddata');
Route::post('/students/uploaddata', [StudentController::class, 'uploaddatastore']);
Route::get('/students/report', [StudentController::class, 'report'])->name('students.report');
Route::get('/students/deleteStudentSchool', [StudentController::class, 'deleteStudentSchool'])->name('students.deleteStudentSchool');
