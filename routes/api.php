<?php

use App\Http\Controllers\Panel\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\BlogController;
use App\Http\Controllers\Website\ServiceController;
use App\Http\Controllers\Website\IndexController;
use App\Http\Controllers\Website\RedirectController;

use App\Http\Controllers\RestrictedDownloadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/*Route::group(['namespace' => 'api','prefix'=>'v1'],function () {
Route::get('email', [IndexController::class, 'index']);
  Route::get('email/inbox', [IndexController::class, 'inbox']);
  Route::get('email/inbox2', [IndexController::class, 'inbox2']);
  Route::get('email/inbox/{id}', [IndexController::class, 'readEmail']);
  Route::get('email/inbox1/{id}', [IndexController::class, 'testGetMail']);
});*/

Route::group(['prefix' => 'v1'], function () {

    Route::post('login', [AuthController::class, 'authenticate']);

    Route::get('sliders', [IndexController::class, 'sliders']);
    Route::get('testimonials', [IndexController::class, 'testimonials']);
    Route::get('services', [ServiceController::class, 'index']);
    Route::get('service/{slug}', [ServiceController::class, 'singleService']);
    Route::post('contact-us', [IndexController::class, 'contactUs']);
    Route::get('blogs', [BlogController::class, 'index']);
    Route::get('blog/{slug}', [BlogController::class, 'singleBlog']);

    Route::post('download', [RestrictedDownloadController::class, 'panelBook']);

    Route::prefix("redirect")->group(function () {
        Route::get("complete", [RedirectController::class, 'status']);
        Route::get("quotafull", [RedirectController::class, 'status']);
        Route::get("terminate", [RedirectController::class, 'status']);
        /*Own Redirect*/
        Route::get("own/complete", [RedirectController::class, 'redirect']);
        Route::get("own/quotafull", [RedirectController::class, 'redirect']);
        Route::get("own/terminate", [RedirectController::class, 'redirect']);
    });

    Route::get('/me', [AuthController::class, 'getAuthenticatedUser'])->middleware('auth:sanctum');
});
