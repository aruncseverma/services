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

// locations routes
Route::group(['prefix' => '/locations', 'namespace' => 'Common\Locations'], function ($route) {
    $route->get('/countries', ['uses' => 'FetchCountriesController@handle', 'as' => 'api.locations.countries']);
    $route->get('/states', ['uses' => 'FetchStatesController@handle', 'as' => 'api.locations.states']);
    $route->get('/cities', ['uses' => 'FetchCitiesController@handle', 'as' => 'api.locations.cities']);
});
// end locations