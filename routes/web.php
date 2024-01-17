<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AccountController,
    ActivityTypeController,
    AddressController,
    AnswerController,
    BlogController,
    ClientController,
    ExportExcelController,
    CompanyController,
    CloseProjectController,
    CurrencyController,
    DashboardController,
    FinalIdController,
    ImageController,
    IndustryController,
    ProjectController,
    InvoiceController,
    LoginActivityController,
    MappingController,
    MasterController,
    RedirectController,
    SamplingController,
    SupplierController,
    SurveyInitController,
    UserController,
    NotificationController,
    PermissionController,
    QuestionController,
    RoleController,
    ServiceController,
    TestimonialController,
};
use Illuminate\Support\Facades\Auth;



Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(MasterController::class)->group(function () {
        Route::get('master', 'index')->name('master.index');
        Route::get('master/export', 'exportReport')->name('master.report');
        Route::get('transfer/supplier', 'supplierTransfer')->name('supplier.transfer');
        Route::get('transfer/user', 'userTransfer')->name('user.transfer');
    });

    Route::controller(AccountController::class)->group(function () {
        Route::get('account', 'index')->name('account.index');
        Route::get('account/projects', 'projects')->name('account.projects');
        Route::post('account/update', 'update')->name('account.update');
        Route::get('account/export', 'exportReport')->name('account.report');
    });

    Route::controller(AddressController::class)->group(function () {
        Route::get('address/state', 'getState')->name('address.state');
        Route::get('address/city', 'getCity')->name('address.city');
    });
    // Route::group(['middleware' => ['auth', 'role:user']], function () {
    Route::controller(ProjectController::class)->group(function () {

        Route::get('/projects', 'index')->name('projects');

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
    });
    // });

    Route::group(['middleware' => 'role:admin,account'], function () {
        Route::get('login_activities', [LoginActivityController::class, 'loginActivity'])->name('login_activities');
        Route::controller(ClientController::class)->group(function () {
            Route::get('clients', 'index')->name('clients.index');
            Route::get('client/create', 'create')->name('client.create');
            Route::post('client/store', 'store')->name('client.store');
            Route::get('client/{id}/edit', 'edit')->name('client.edit');
            Route::post('client/update', 'update')->name('client.update');
            Route::get('client/{id}', 'show')->name('client.show');
            Route::delete('client/{id}', 'destroy')->name('client.destroy');
            Route::post('client/status', 'changeStatus')->name('client.status');
            Route::get('client/{id}/projects', 'projects')->name('client.projects');
            Route::get('client/{id}/address', 'address')->name('client.address');
            Route::get('client/{id}/addresses', 'addresses')->name('client.addresses');
            Route::post('client/addAddress/{id}', 'addAddress')->name('client.addAddress');
            Route::post('client/updateAddress/{id}', 'updateAddress')->name('client.updateAddress');
            Route::delete('client/delAddress/{id}', 'delAddress')->name('client.delAddress');
            Route::get('client/project/report', 'exportProjectIds')->name('client.project.report');
        });
        Route::controller(MappingController::class)->group(function () {
            Route::get('mapping/{id}', 'show')->name('mapping.show');
            Route::get('mapping/{id}/create', 'create')->name('mapping.create');
            Route::post('mapping/{id}/store', 'store')->name('mapping.store');

            Route::get('mapping/{id}/suppliers', 'suppliers')->name('mapping.suppliers');
            Route::get('project-link/{id}/suppliers', 'projectLinkSuppliers')->name('project-link.suppliers');



            Route::get('mapping/{id}/edit', 'edit')->name('mapping.edit');
            Route::post('mapping/{id}/update', 'update')->name('mapping.update');

            Route::delete('mapping/{id}', 'destroy')->name('mapping.destroy');
            Route::post('mapping/status', 'status')->name('mapping.status');
            Route::post('mapping/sample-size', 'sampleSize')->name('mapping.sample-size');
        });
        Route::controller(SamplingController::class)->group(function () {
            Route::get('sampling/{id}/create', 'create')->name('sampling.create');
            Route::post('sampling/store', 'store')->name('sampling.store');

            Route::get('sampling/{id}/edit', 'edit')->name('sampling.edit');
            Route::post('sampling/{id}/update', 'update')->name('sampling.update');

            Route::get('sampling/{id}', 'show')->name('sampling.show');
            Route::delete('sampling/{id}', 'destroy')->name('sampling.destroy');
            Route::post('sampling/status', 'status')->name('sampling.status');
            Route::get('sampling/{id}/redirect', 'redirect')->name('sampling.redirect');
        });
        Route::controller(SupplierController::class)->group(function () {
            Route::get('suppliers', 'index')->name('suppliers.index');
            Route::get('supplier/create', 'create')->name('supplier.create');
            Route::post('supplier/store', 'store')->name('supplier.store');
            Route::get('supplier/{id}/edit', 'edit')->name('supplier.edit');
            Route::post('supplier/update', 'update')->name('supplier.update');
            Route::get('supplier/{id}', 'show')->name('supplier.show');
            Route::delete('supplier/{id}', 'destroy')->name('supplier.destroy');
            //supplier Project
            Route::get('supplier/{id}/projects', 'projects')->name('supplier.projects');
            //supplier Project
            Route::get('supplier/{id}/redirect', 'redirect')->name('supplier.redirect');
            //Respodents
            Route::get('supplier/{id}/respondents', 'respondents')->name('supplier.respondents');
            //Suppliers Reports
            Route::get('supplier/{id}/export', 'supplierExports')->name('supplier.export');


            Route::post('supplier/redirect/update', 'updateRedirect')->name('supplier.redirect.update');
            //Supplier Status
            Route::post('supplier/status', 'changeStatus')->name('supplier.status');
            // excel export
            Route::get('supplier/{id}/projects/export', 'exportIds')->name('supplier.projects.export');
        });
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
        Route::controller(FinalIdController::class)->group(function () {
            Route::get('final-id', 'index')->name('final-id.index');
            Route::get('final-id/{id}/export', 'export')->name('final-id.export');
        });
        Route::controller(CompanyController::class)->group(function () {
            Route::group(['prefix' => 'company'], function () {
                Route::get('/', 'show')->name('company.index');
                Route::post('/update', 'update')->name('company.update');
                Route::get('/address', 'address')->name('company.address');
                Route::post('/address', 'updateAddress')->name('company.updateAddress');
                Route::get('account', 'account')->name('company.account');
                Route::post('/account', 'updateAccount')->name('company.updateAccount');
            });
        });
        Route::controller(CloseProjectController::class)->group(function () {
            Route::get('/close-projects', 'index')->name('close-projects');
            Route::post('close-project/restore', 'restore')->name('close-project.restore');
            Route::get('close-project/download/{id}', 'download')->name('close-project.download');
            Route::delete('close-project/destroy/{id}', 'destroy')->name('close-project.destroy');
        });
        Route::resource('service', ServiceController::class);
        Route::resource('blog', BlogController::class);
        Route::post('blog/status', [BlogController::class, 'statusUpdate'])->name('blog.status');
        Route::resource('testimonial', TestimonialController::class);
        Route::post('testimonial/status', [TestimonialController::class, 'statusUpdate'])->name('testimonial.status');
        Route::controller(QuestionController::class)->group(function () {
            Route::get('questions', 'index')->name('questions.index');
            Route::group(['prefix' => 'question'], function () {
                Route::post('store', 'store')->name('question.store');
                Route::get('{id}/edit', 'edit')->name('question.edit');
                Route::get('{id}', 'show')->name('question.show');
                Route::post('update', 'update')->name('question.update');
                Route::delete('delete/{id}', 'destroy')->name('question.delete');
            });
        });

        Route::controller(AnswerController::class)->group(function () {
            Route::get('answers', 'index')->name('answers.index');
            Route::group(['prefix' => 'answer'], function () {
                Route::post('store', 'store')->name('answer.store');
                Route::get('{id}/edit', 'edit')->name('answer.edit');
                Route::post('update', 'update')->name('answer.update');
                Route::delete('delete/{id}', 'destroy')->name('answer.delete');
            });
        });
        Route::controller(ActivityTypeController::class)->group(function () {
            Route::get('activity_types', 'index')->name('activity_types.index');
            Route::group(['prefix' => 'activity_type'], function () {
                Route::post('store', 'store')->name('activity_type.store');
                Route::get('edit', 'edit')->name('activity_type.edit');
                Route::post('update', 'update')->name('activity_type.update');
                Route::delete('destroy/{id}', 'destroy')->name('activity_type.destroy');
            });
        });

        Route::controller(IndustryController::class)->group(function () {
            Route::get('industries', 'index')->name('industries.index');
            Route::group(['prefix' => 'industry'], function () {
                Route::post('status',  'statusUpdate')->name('industry.status');
                Route::post('store', 'store')->name('industry.store');
                Route::get('{id}/edit', 'edit')->name('industry.edit');
                Route::post('update', 'update')->name('industry.update');
                Route::delete('destroy/{id}', 'destroy')->name('industry.destroy');
            });
        });

        Route::controller(RoleController::class)->group(function () {
            Route::group(['prefix' => 'role'], function () {
                Route::get('/', 'index')->name('role.index');
                Route::post('/store', 'store')->name('role.store');
                Route::get('{id}', 'show')->name('role.show');
                Route::get('{id}/edit', 'edit')->name('role.edit');
                Route::post('{id}/update', 'update')->name('role.update');
                Route::delete('delete/{id}', 'destroy')->name('role.destroy');
            });
        });
        Route::controller(PermissionController::class)->group(function () {
            Route::get('/permissions', 'index')->name('permission.index');
            Route::group(['prefix' => 'permission'], function () {
                Route::post('/store', 'store')->name('permission.store');
                Route::get('{id}/edit', 'edit')->name('permission.edit');
                Route::post('{id}/update', 'update')->name('permission.update');
                Route::delete('destroy/{id}', 'destroy')->name('permission.destroy');
            });
        });
        Route::controller(ImageController::class)->group(function () {
            Route::post('/image/{entity}', 'store')->name('image.store');
        });
    });

    Route::group(['middleware' => 'role:admin'], function () {
        Route::get('invoice/download/{id}', [InvoiceController::class, 'downloadInvoice']);
        Route::controller(InvoiceController::class)->group(function () {
            Route::get('/invoices', 'index')->name('invoice.index');
            Route::group(['prefix' => 'invoice'], function () {
                Route::get('create', 'create')->name('invoice.create');
                Route::post('/store', 'store')->name('invoice.store');
                Route::get('/{id}', 'show')->name('invoice.show');
                Route::get('{id}/edit', 'edit')->name('invoice.edit');
                Route::post('{id}/update', 'update')->name('invoice.update');
            });
        });
        Route::get('invoice/{id}/currency-value', [CurrencyController::class, 'currenctValue'])->name('invoice.currency-value');
    });
    Route::controller(ExportExcelController::class)->group(function () {
        Route::get('export/excel', 'exportExcelFile')->name('export.excel');
    });
    route::get('notifications', [NotificationController::class, 'index'])->name('notifications');
});

Route::group(['prefix' => 'survey'], function () {
    Route::get('vendor/{pid}', [SurveyInitController::class, 'supplier']);
    Route::get('init/{pid}/{uid}', [SurveyInitController::class, 'init']);
});

Route::group(['prefix' => 'redirect'], function () {
    Route::get('{slug}', [RedirectController::class, 'surveyEnd']);
});
