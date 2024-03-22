<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AccountController,
    DashboardController,
    ProjectController,
    UserController,
};

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(AccountController::class)->group(function () {
        Route::get('account', 'index')->name('account.index');
        Route::get('account/projects', 'projects')->name('account.projects');
        Route::post('account/update', 'update')->name('account.update');
        Route::get('account/export', 'exportReport')->name('account.report');
    });
    Route::controller(ProjectController::class)->group(function () {

        Route::get('/projects', 'index')->name('projects.index');

        Route::get('project/create', 'create')->name('project.create');

        //project state city

        Route::get('project/state', 'getState')->name('project.state');

        Route::get('project/city', 'getCity')->name('project.city');

        Route::post('project/store', 'store')->name('project.store');

        Route::get('/project/{id}',  'show')->name('project.show');

        Route::get('project/{id}/edit', 'edit')->name('project.edit');

        Route::post('project/{id}/update', 'update')->name('project.update');

        //Project Suppliers
        Route::get('project/{id}/suppliers', 'suppliers')->name('project.suppliers');

        //activity
        Route::get('project/{id}/activity', 'activity')->name('project.activity');

        Route::delete('project/{id}', 'destroy')->name('project.destroy');

        Route::post('project/status', 'status')->name('project.status');

        // Clone Project
        Route::post('project/clone', 'projectClone')->name('project.clone');

        Route::delete('project/{id}/removeid', 'removeIds')->name('project.removeid');

        //Excel Export import
        Route::post('project/{id}/importid', 'importId')->name('project.importid');

        Route::get('project/{id}/export', 'exportId')->name('project.export');

        Route::get('project/{id}/report', 'report')->name('project.report');
        Route::get('project/{id}/finalids', 'finalIds')->name('project.finalids');
    });

    Route::group(['middleware' => 'role:admin,account'], function () {


        Route::controller(UserController::class)->group(function () {
            Route::get('users', 'index')->name('users.index');
            Route::get('user/create', 'create')->name('user.create');
            Route::post('user/store', 'store')->name('user.store');
            Route::get('user/{id}/edit', 'edit')->name('user.edit');
            Route::post('user/{id}/update', 'update')->name('user.update');
            Route::get('user/{id}', 'show')->name('user.show');
            Route::delete('user/{id}', 'destroy')->name('user.destroy');
            // User Project
            Route::get('user/{id}/projects', 'projects')->name('user.projects');
            // User Address
            Route::get('user/{id}/address', 'address')->name('user.address');
            Route::post('user/addAddress/{id}', 'addAddress')->name('user.addAddress');
            Route::post('user/updateAddress/{id}', 'updateAddress')->name('user.updateAddress');
            Route::delete('user/delAddress/{id}', 'delAddress')->name('user.delAddress');
            //Excel export
            Route::get('user-project/export', 'exportProjectIds')->name('user-project.report');
        });
    });
});
