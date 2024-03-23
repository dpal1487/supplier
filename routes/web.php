<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Auth\AuthController,
    AccountController,
    DashboardController,
    ProjectController,
    MasterController
};

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(AccountController::class)->group(function () {
        Route::get('account', 'index')->name('account.index');
        Route::get('account/projects', 'projects')->name('account.projects');
        Route::post('account/store', 'store')->name('account.store');
        Route::post('profile-image/store', 'image')->name('profile-image.store');
        Route::get('account/export', 'exportReport')->name('account.report');
    });
    Route::controller(ProjectController::class)->group(function () {
        Route::get('/projects', 'index')->name('projects.index');
        //Project Suppliers
        Route::get('project/{id}/suppliers', 'suppliers')->name('project.suppliers');
        Route::get('project/report', 'report')->name('project.report');
    });
    Route::controller(MasterController::class)->group(function () {
        Route::get('project-reports', 'index')->name('project-reports.index');
        Route::get('project-reports/export', 'exportReport')->name('project-reports.report');
    });
});
