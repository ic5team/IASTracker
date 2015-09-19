<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

	Route::resource('IAS', 'IASController');
	Route::resource('IASTaxon', 'IASTaxonController');
	Route::resource('language', 'LanguagesController');
	Route::resource('observation', 'ObservationController');
	Route::resource('region', 'RegionController');
	Route::resource('repository', 'RepositoryController');
	Route::resource('status', 'StatusController');
	Route::resource('user', 'UserController');

	Route::get('/', array('as' => 'inici', 'uses' => 'IndexController@showIndex'));
	Route::post('/', array('uses' => 'IndexController@showIndex'));
	Route::get('/cookies', array('uses' => 'IndexController@showCookies'));
	Route::get('/logout', array('uses' => 'IndexController@logout'));
	Route::get('/account/activate', array('uses' => 'UserController@activate'));
	Route::get('/password/reset', array('uses' => 'UserController@resetPassword'));

/*
|--------------------------------------------------------------------------
| AJAX
|--------------------------------------------------------------------------
*/

	Route::get('/v1/IASFilter', array('uses' => 'IASController@getFilter'));
	Route::get('/v1/Observations', array('uses' => 'ObservationController@index'));
	Route::get('/v1/Observations/{id}', array('uses' => 'ObservationController@show'));
	Route::get('/v1/IAS/{id}', array('uses' => 'IASController@show'));
	Route::get('/v1/IAS/{id}/Observations', array('uses' => 'IASController@getObservations'));
	Route::get('/v1/States/{id}/Regions', array('uses' => 'StateController@getRegions'));
	Route::get('/v1/Regions/{id}/Areas', array('uses' => 'RegionController@getAreas'));
	Route::post('/v1/Users/', array('uses' => 'UserController@store'));
	Route::put('/v1/Users/', array('uses' => 'UserController@remind'));
	Route::put('/v1/Users/{id}', array('uses' => 'UserController@update'));
	Route::get('/v1/Users/{id}', array('uses' => 'UserController@show'));
	Route::get('/v1/Users/{id}/Observations', array('uses' => 'UserController@getObservations'));
