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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/home/{id}', 'HomeController@home')->name('home');
Route::get('/logout','Auth\LoginController@logout');

Route::get('/organisation/{id}','OrganisationController@index');
Route::get('/organisation/{id}/add','OrganisationController@add');
Route::post('/organisation/{id}/add','OrganisationController@create');

Route::get('/project/{id}','ProjectController@index');
Route::get('/project/{id}/add','ProjectController@add');
Route::post('/project/{id}/add','ProjectController@create');

Route::get('/scenario/{id}','ScenarioController@index');
Route::get('/scenario/{id}/add','ScenarioController@add');
Route::post('/scenario/{id}/add','ScenarioController@create');

Route::get('/scenario_parameter/{id}','ScenarioParameterController@index');
Route::get('/scenario_parameter/{id}/add','ScenarioParameterController@add');
Route::post('/scenario_parameter/{id}/add','ScenarioParameterController@create');

Route::get('/scenario_script/{id}','ScenarioScriptController@index');
Route::get('/scenario_script/{id}/add','ScenarioScriptController@add');
Route::post('/scenario_script/{id}/add','ScenarioScriptController@create');

Route::get('/scenario_operation/{id}','ScenarioOperationController@index');
Route::get('/scenario_operation/{id}/add','ScenarioOperationController@add');
Route::post('/scenario_operation/{id}/add','ScenarioOperationController@create');
