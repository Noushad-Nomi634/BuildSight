<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CameraController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StorageController;


Route::middleware(['auth', 'role:super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('dashboard');

            Route::get('/company', [AdminController::class, 'companydasboard'])
    ->name('company.index');

      Route::get('/company/create', [CompanyController::class, 'createCompany'])
    ->name('company.create');
        Route::post('/company', [AdminController::class, 'storeCompany'])
            ->name('company.store');
Route::get('/company', [AdminController::class, 'listCompany'])
            ->name('company.index');
 Route::get('/company/{id}', [AdminController::class, 'show'])
    ->name('company.show');
Route::get('/company/{id}/edit', [AdminController::class, 'edit'])
    ->name('company.edit');
Route::put('/company/{id}', [AdminController::class, 'update'])
    ->name('company.update');
Route::delete('/company/{id}', [AdminController::class, 'destroy'])
    ->name('company.destroy');

    
    


    //storage routes
Route::get('/storage', [StorageController::class, 'index'])->name('storage.index');
Route::get('/storage/create', [StorageController::class, 'create'])->name('storage.create');
Route::post('/storage/store', [StorageController::class, 'store'])->name('storage.store');
Route::get('/storage/edit/{id}', [StorageController::class, 'edit'])->name('storage.edit');
Route::put('/storage/update/{id}', [StorageController::class, 'update'])->name('storage.update');
Route::get('/storage/delete/{id}', [StorageController::class, 'delete'])->name('storage.delete');



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
        Route::get('/cameras/create', [CameraController::class, 'create'])
    ->name('cameras.create');

        Route::get('/cameras', [CameraController::class, 'index'])->name('cameras.index');
    Route::get('/cameras/{camera}', [CameraController::class, 'show'])->name('cameras.show');
    Route::get('/cameras/{camera}/edit', [CameraController::class, 'edit'])->name('cameras.edit');
        
        Route::post('cameras', [\App\Http\Controllers\CameraController::class, 'store'])
            ->name('cameras.store');
            Route::put('/cameras/{camera}', [CameraController::class, 'update'])->name('cameras.update');
    Route::delete('/cameras/{camera}', [CameraController::class, 'destroy'])->name('cameras.destroy');
    Route::get('/cameras/create', [CameraController::class, 'create'])
    ->name('cameras.create');


    // COUNTRIES
Route::get('/countries', [CountryController::class, 'index'])->name('countries.index');

Route::get('/countries/create', [CountryController::class, 'create'])->name('countries.create');

Route::post('/countries', [CountryController::class, 'store'])->name('countries.store');

Route::get('/countries/{id}', [CountryController::class, 'show'])->name('countries.show');

Route::get('/countries/{id}/edit', [CountryController::class, 'edit'])->name('countries.edit');

Route::put('/countries/{id}', [CountryController::class, 'update'])->name('countries.update');

Route::delete('/countries/{id}', [CountryController::class, 'destroy'])->name('countries.destroy');

    // CITIES
    Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
    Route::get('/cities/create', [CityController::class, 'create'])->name('cities.create');
    Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
    Route::get('/cities/{id}', [CityController::class, 'show'])->name('cities.show');
    Route::get('/cities/{id}/edit', [CityController::class, 'edit'])->name('cities.edit');
    Route::put('/cities/{id}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('/cities/{id}', [CityController::class, 'destroy'])->name('cities.destroy');

        });
        Route::get('/projects/{project}', [ProjectController::class, 'show'])
    ->name('company.projects.show');

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
