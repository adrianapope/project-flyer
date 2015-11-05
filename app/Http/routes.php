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

Route::get('/', function () {
    return view('pages.home');
});

Route::resource('flyers', 'FlyersController');
Route::get('{zip}/{street}', 'FlyersController@show');
Route::post('{zip}/{street}/photos', 'FlyersController@addPhoto');

//projectflyer.com/90808/5529-east-keynote-street

// we want to use zip street to track down a specific flyer.
// if i do a post request to that it will create or store a new photo that
// is associated with this flyer
//zip/street/photos  example: /flyers/1/photos