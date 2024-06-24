<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PermissionsController;

use App\Livewire\Security;
use App\Livewire\DependenciesController;
use App\Livewire\DependenciesAreasController;
use App\Livewire\LogsController;
use App\Livewire\UsersSystem;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('user_permissions', [PermissionsController::class, 'getUserPermissions'])->name('user_permissions');
    Route::post('/update_default_password', [UsersController::class, 'changePassword'])->name('update_default_password');
    Route::get('/newPassView', [UsersController::class, 'changePasswordView'])->name('newPassView');


    Route::middleware(['auth', 'permission:user_window'])->group(function () {
        Route::get('users', [UsersController::class, 'index'])->name('users');
        Route::post('users_edit', [UsersController::class, 'edit']);
        Route::post('users_create', [UsersController::class, 'store']);
        Route::post('users_delete', [UsersController::class, 'delete']);
        Route::post('users_reset', [UsersController::class, 'reset']);
        /*Route::get('/users', [UsersController::class, 'index'])
        ->name('users');*/
    });

    Route::middleware(['auth', 'permission:security_window'])->group(function () {
        Route::get('/security', Security::class)->name('security');
        Route::get('/logs', LogsController::class)->name('logs_info');
        Route::get('logs_table_info', [LogsController::class, 'index'])->name('logs_table');
    });
    Route::middleware(['auth', 'permission:dependence_window'])->group(function () {
        Route::get('dependence_info', [DependenciesController::class, 'index'])->name('dependence_info');
        Route::post('delete_rgsdependence', [DependenciesController::class, 'delete'])->name('delete_rgsdependence');
        Route::get('/dependence', DependenciesController::class)->name('dependence');
        Route::get('AddAreas/{id?}', DependenciesAreasController::class)->name('AddAreas');
        Route::get('getAreas', [DependenciesAreasController::class, 'getAreas'])->name('getAreas');
    });

    Route::middleware(['auth', 'permission:users_system'])->group(function () {
        Route::get('/users_system', UsersSystem::class)->name('users_system');
        Route::get('/userstable', [UsersSystem::class, 'getUsersData'])->name('users_info');

    });
    //Route::get('/users', [UsersController::class, 'index'])->name('users');
    /*Route::get('/users', function() {
        return view('/forms/users');
    })->name('users');*/
});
