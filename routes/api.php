<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::resource('users', UserController::class);


// ----  IN PROGRESS ---

Route::resource('websites', WebsiteController::class);

Route::group(['prefix' => 'websites/{website}'], function () {
    Route::post('subscribe', SubscriptionController::class.'@store');
    Route::get('subscribed', SubscriptionController::class.'@show');
    Route::delete('unsubscribe', SubscriptionController::class.'@destroy');
    Route::get('subscribers', SubscriptionController::class.'@index');

    Route::resource('/posts', PostController::class);
});




