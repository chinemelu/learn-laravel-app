<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'uses' => 'App\Http\Controllers\ProductController@getIndex',
    'as' => 'product.index'
]);

Route::get('/add-to-cart/{id}',  [
    'uses' => 'ProductController@getAddToCart',
    'as' => 'product.addToCart'
]);

Route::group(['prefix' => 'user'], function() {
    Route::group(['middleware' => 'guest'], function() {
        Route::get('/signup', [
            'uses' =>  'App\Http\Controllers\UserController@getSignup',
            'as' => 'user.signup',
        ]);
    
        Route::post('/signup', [
            'uses' =>  'App\Http\Controllers\UserController@postSignup',
            'as' => 'user.signup',
        ]);
        
        Route::get('/signin', [
            'uses' =>  'App\Http\Controllers\UserController@getSignin',
            'as' => 'user.signin',
        ]);
        
        Route::post('/signin', [ 
            'uses' =>  'App\Http\Controllers\UserController@postSignin',
            'as' => 'user.signin',
        ]);
    });

    Route::group(['middleware' => 'auth'], function() {
        Route::get('/profile', [
            'uses' => 'App\Http\Controllers\UserController@getProfile',
            'as' => 'user.profile',
        ]);
        
        Route::get('/logout', [
            'uses' => 'App\Http\Controllers\UserController@getLogout',
            'as' => 'user.logout',
        ]);
    });
});