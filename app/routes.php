<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
*/

Route::any('/', array('as' => 'index', 'uses' => 'HomeController@index'));
Route::get('/success', array('as' => 'success', 'uses' => 'HomeController@success'));
