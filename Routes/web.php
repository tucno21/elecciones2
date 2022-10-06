<?php

use System\Route;
use App\Controller\Auth\LoginController;
use App\Controller\BackView\QrController;
use App\Controller\BackView\RolController;
use App\Controller\BackView\UserController;
use App\Controller\BackView\MemberController;
use App\Controller\BackView\SchoolController;
use App\Controller\BackView\VotingController;
use App\Controller\BackView\StudentController;
use App\Controller\BackView\CandidateController;
use App\Controller\BackView\DashboardController;
use App\Controller\BackView\PermissionController;
use App\Controller\BackView\VotingGroupController;
use App\Controller\BackView\StudentRolesController;
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
Route::get('/dashboard/charts', [DashboardController::class, 'charts'])->name('dashboard.charts');
Route::get('/dashboard/excel', [DashboardController::class, "excel"])->name('dashboard.excel');

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
Route::get('/votinggroups/pdf', [VotingGroupController::class, 'pdf'])->name('votinggroups.pdf');
Route::get('/votinggroups/pdfwall', [VotingGroupController::class, 'pdfWall'])->name('votinggroups.pdfWall');

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

//studentroles
Route::get('/studentroles', [StudentRolesController::class, 'index'])->name('studentroles.index');
Route::get('/studentroles/create', [StudentRolesController::class, 'create'])->name('studentroles.create');
Route::post('/studentroles/create', [StudentRolesController::class, 'store']);
Route::get('/studentroles/edit', [StudentRolesController::class, 'edit'])->name('studentroles.edit');
Route::post('/studentroles/edit', [StudentRolesController::class, 'update']);
Route::get('/studentroles/destroy', [StudentRolesController::class, 'destroy'])->name('studentroles.destroy');

//miembros de mesa
Route::get('/members', [MemberController::class, 'index'])->name('members.index');
//lista de miembros de mesa
Route::get('/members/members', [MemberController::class, 'members'])->name('members.members');
//buscar DNI
Route::get('/members/search', [MemberController::class, 'search'])->name('members.search');
Route::get('/members/student', [MemberController::class, 'student'])->name('members.student');

Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
Route::post('/members/create', [MemberController::class, 'store']);
Route::get('/members/edit', [MemberController::class, 'edit'])->name('members.edit');
Route::post('/members/edit', [MemberController::class, 'update']);
Route::get('/members/destroy', [MemberController::class, 'destroy'])->name('members.destroy');

//crud candidates
Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
Route::get('/candidates/create', [CandidateController::class, 'create'])->name('candidates.create');
Route::post('/candidates/create', [CandidateController::class, 'store']);
Route::get('/candidates/edit', [CandidateController::class, 'edit'])->name('candidates.edit');
Route::post('/candidates/edit', [CandidateController::class, 'update']);
Route::get('/candidates/delete', [CandidateController::class, 'destroy'])->name('candidates.destroy');

//qr
Route::get('/qr', [QrController::class, 'index'])->name('qr.index');

//votaciones
Route::get('/votings', [VotingController::class, 'index'])->name('votings.index');
Route::get('/votings/create', [VotingController::class, 'create'])->name('votings.create');
Route::post('/votings/create', [VotingController::class, 'store']);
Route::get('/votings/camera', [VotingController::class, 'camera'])->name('votings.camera');

Route::get('/votings/search', [VotingController::class, 'search'])->name('votings.search');

Route::get('/votings/studentvoto', [VotingController::class, 'candidate'])->name('votings.candidate');
Route::post('/votings/studentvoto', [VotingController::class, 'candidatePost']);

Route::get('/votings/close', [VotingController::class, 'close'])->name('votings.close');
