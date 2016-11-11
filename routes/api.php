<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// Register
Route::post('/register', 'RegisterController@store');

// login
Route::post('/login', 'LoginController@login');

// Lives
Route::get('/live/genre/{genre}', 'LivesController@show');
Route::get('/live/{live}', 'LivesController@showStreamUrl');

// Titles
Route::get('/title/kind/{kind}/genre/{genre}', 'TitlesController@show');
Route::get('/title/kind/{kind}/genre/{genre}/before/{title}', 'TitlesController@showBeforeId');
Route::get('/title/kind/{kind}/genre/{genre}/after/{title}', 'TitlesController@showAfterId');
Route::get('/title/{title}/{language}', 'TitlesController@showStreamUrl');
Route::get('/episode/title/{title}', 'TitlesController@episodeList');

// Titles Search
Route::get('/title/{title}/kind/{kind}', 'TitlesController@search');

// Subscription
Route::post('/subscription', 'SubscriptionsController@store');
Route::get('/user/subscriptions', 'UsersController@showSubscriptions');
Route::get('/user/subscription/last', 'UsersController@showLastSubscription');

// Version
Route::get('version', 'VersionsController@index');
