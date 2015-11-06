<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', 'MainController@mainPage');
Route::get('home', 'MainController@mainPage');
Route::get('pro', 'MainController@pro');
Route::post('createSubscription', 'MainController@createSubscription');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Contact Route
Route::get('contact', 'ContactController@getContact');
Route::post('contact', 'ContactController@sendMail');


// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Settings/Payment issues routes:
Route::get('settings', 'SettingsController@getSettings');


/*
//Flashcard routes...
Route::get('card/create', 'FlashcardController@create');
Route::post('card/store', 'FlashcardController@store');
Route::get('card/list', 'FlashcardController@index');
*/

//Deck routes...


Route::get('deck/create', 'DeckController@create');
Route::get('deck/{id}/add', 'DeckController@addCard');
Route::post('deck/store', 'DeckController@store');
Route::post('deck/{id}/storeCard', 'DeckController@storeCard');
Route::post('deck/{id}/storeUser', 'DeckController@storeUser');
Route::post('deck/{id}/deleteCard', 'DeckController@deleteCard');
Route::post('deck/{id}/editCard', 'DeckController@editCard');
Route::post('deck/{id}/delete', 'DeckController@deleteDeck');
Route::post('deck/{id}/deleteUser', 'DeckController@deleteUser');


//stat routes
Route::get('deck/{id}/stats', 'StatsController@deckStats');

//session routes
Route::get('deck/{id}/{type}', 'SessionController@startSession');
Route::get('deck/{id}/{type}/next', 'SessionController@next');
Route::post('deck/{id}/{type}/next', 'SessionController@next');

//stat routes
Route::get('deck/{id}/stats', 'StatsController@deckStats');

Route::filter('csrf', function() {
    $token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');
    if (Session::token() != $token)
        throw new Illuminate\Session\TokenMismatchException;
});
