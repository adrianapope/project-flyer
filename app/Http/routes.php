<?php

# Pages
Route::get('/', 'PagesController@home');

# Authentication
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

# Registration
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

# Flyers
Route::post('/flyer/create', 'FlyersController@store'); // temp
Route::resource('/flyers', 'FlyersController');
Route::get('{zip}/{street}', 'FlyersController@show');

# Photos
Route::post('{zip}/{street}/photos', ['as' => 'store_photo_path', 'uses' => 'PhotosController@store']);

