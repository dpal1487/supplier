<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\AuthController;
use App\Http\Controllers\Panel\InfoController;
use App\Http\Controllers\Panel\OfferController;
use App\Http\Controllers\Panel\ForgetController;
use App\Http\Controllers\Panel\ReviewController;
use App\Http\Controllers\Panel\RewardController;
use App\Http\Controllers\Panel\SocialController;
use App\Http\Controllers\Panel\SurveyController;
use App\Http\Controllers\Panel\AddressController;
use App\Http\Controllers\Panel\ProfileController;
use App\Http\Controllers\Panel\SettingController;
use App\Http\Controllers\Panel\SupportController;
use App\Http\Controllers\Panel\FeedbackController;
use App\Http\Controllers\Panel\ReferralController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\PromotionController;
use App\Http\Controllers\Panel\WithdrawalController;
use App\Http\Controllers\Panel\TransactionController;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register user routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "user" middleware group. Now create something great!
|
*/


Route::group(['prefix' => 'v1'], function () {



    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/daily-surveys', [DashboardController::class, 'dailySurvey']);
        Route::get('/newsletters', [DashboardController::class, 'newsLetter']);
        Route::post('/storeReport', [DashboardController::class, 'storeReport']);
        Route::get('/referral-users', [DashboardController::class, 'referralUser']);
    });
    /*Auth Controller*/
    /*  Route::group(['prefix'=>'auth'],function () {
    Route::post('registeration', [RegisterController::class,'register']);
    Route::post('login', [LoginController::class,'login']);
  }); */

    //Panel Authentication
    //Here is the protected Admin Routes Group
    Route::post('login', [AuthController::class, 'authenticate']);
    Route::post('register', [AuthController::class, 'register']);
    // Route::post('sociallogin/{provider}', 'Auth\AuthController@SocialSignup');
    // Route::get('auth/{provider}/callback', 'OutController@index')->where('provider', '.*');

    Route::get('', [SocialController::class, 'index']);
    Route::get('sociallogin/{provider}', [SocialController::class, 'SocialSignup'])->name('social.oauth');
    Route::get('sociallogin/{provider}/callback', [SocialController::class, 'loginWithSocial'])->name('social.callback');

    Route::post('email/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('email/verify', [AuthController::class, 'verify']);
    Route::post('email/resend-verification', [AuthController::class, 'resendVerification']);
    Route::post('email/send-otp', [AuthController::class, 'sendOtp']);

    Route::post('forget/send-otp', [ForgetController::class, 'sendOtp']);
    Route::post('forget/verify-otp', [ForgetController::class, 'verifyOtp']);
    Route::get('customer-reviews', [FeedbackController::class, 'index']);
    Route::get('countries', [AddressController::class, 'getCountries']);
    Route::get('states', [AddressController::class, 'getStateByCountryId']);
    Route::get('cities', [AddressController::class, 'getCityByCountryId']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Broadcast::routes(['middleware' => ['auth:sanctum']]);

        Route::group(['prefix' => 'account'], function () {
            Route::post('/change-image', [ProfileController::class, 'profileImageUpdate']);
            Route::get('/withdrawals', [WithdrawalController::class, 'index']);
            Route::get('/offer', [OfferController::class, 'index']);
            Route::get('/promotion', [PromotionController::class, 'index']);
            Route::post('/profile', [ProfileController::class, 'update']);
            Route::get('/transactions', [TransactionController::class, 'index']);
            Route::get('/referral', [ReferralController::class, 'index']);
            Route::get('/user', [ProfileController::class, 'getUser']);
            Route::get('/address', [AddressController::class, 'index']);
            Route::post('/address/update', [AddressController::class, 'update']);
            Route::post('/change-password', [SettingController::class, 'updateChangePassword']);
            Route::get('/settings', [SettingController::class, 'index']);
            Route::post('/setting-update', [SettingController::class, 'updateSetting']);
        });
        Route::get('/me', [AuthController::class, 'getAuthenticatedUser']);

        //Route::post('/getticket',[SupportController::class,'index']);
        Route::post('/addticket', [SupportController::class, 'store']);
        Route::get('/open-ticket', [SupportController::class, 'index']);

        /*-- Profile Information Start--*/
        Route::get('/profile-survey', [InfoController::class, 'index']);
        Route::get('/profile-survey/{id}', [InfoController::class, 'getProfile']);
        Route::post('/profile-survey/{id}', [InfoController::class, 'postProfile']);
        Route::get('/surveys', [SurveyController::class, 'index']);
        Route::get('/rewards', [RewardController::class, 'index']);
        Route::get('feedback/category', [FeedbackController::class, 'category']);
        Route::post('feedback/store', [FeedbackController::class, 'store']);

        Route::get('offers', [OfferController::class, 'index']);

        Route::get('review', [ReviewController::class, 'index']);
        Route::post('review', [ReviewController::class, 'store']);


        /*Route::group(['prefix'=>'profile'],function()
            {
                Route::get('/{id}',[InfoController::class,'getProfile']);
                Route::post('/{id}',[InfoController::class,'postProfile']);
            });*/
    });
});
