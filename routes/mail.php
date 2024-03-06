<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Email\IndexController;

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

Route::group(['namespace' => 'mail','prefix'=>'v1'],function () {
Route::get('email', [IndexController::class, 'index']);
  Route::get('email/inbox', [IndexController::class, 'inbox']);
  Route::get('email/inbox2', [IndexController::class, 'inbox2']);
  Route::get('email/inbox/{id}', [IndexController::class, 'readEmail']);
  Route::get('email/inbox1/{id}', [IndexController::class, 'testGetMail']);
});

