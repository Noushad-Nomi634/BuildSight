<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Company\InvitationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])
            ->name('index');

        Route::get('/company/create', [AdminController::class, 'createCompany'])
            ->name('company.create');
        Route::post('/company', [AdminController::class, 'storeCompany'])
            ->name('company.store');


        Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('role.update.permission');
        Route::put('roles/{role}/users', [RoleController::class, 'updateUsers'])->name('roles.update.users');
    });
Route::middleware(['auth'])
    ->prefix('company')
    ->name('company.')
    ->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('dashboard');

        Route::get('/users', [InvitationController::class, 'index'])
            ->name('users.index');

        Route::post('/invitations', [InvitationController::class, 'store'])
            ->name('invitations.store');

        Route::post('/invitations/{invitation}/resend', [InvitationController::class, 'resend'])
            ->name('invitations.resend');

        Route::delete('/invitations/{invitation}', [InvitationController::class, 'cancel'])
            ->name('invitations.cancel');

        Route::put('/invitations/{invitation}/role', [InvitationController::class, 'assignRole'])
            ->name('invitations.role');
        Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::get('projects/edit/{project}', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
        Route::put('projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    });

Route::get('/invitations/accept/{token}', [InvitationController::class, 'accept'])
    ->name('invitations.accept');

Route::post('/invitations/accept/{token}', [InvitationController::class, 'completeRegistration'])
    ->name('invitations.complete');


Route::middleware(['auth', 'role:super_admin,company'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('roles', RoleController::class)->except(['show', 'create', 'edit']);
        Route::resource('permissions', PermissionController::class);

        Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('role.update.permission');
        Route::put('roles/{role}/users', [RoleController::class, 'updateUsers'])->name('roles.update.users');
    });
Route::middleware(['auth'])
    ->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');
    });


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'RegisterView'])->name('register');
Route::get('/password/reset/request', [AuthController::class, 'passwordRequest'])->name('password.request');
