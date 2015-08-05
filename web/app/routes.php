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
