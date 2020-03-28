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
Route::get('/project/{id}/add/','ProjectController@add');
Route::post('/project/{id}/add','ProjectController@create');
Route::get('/project/{id}/edit/{this_id}','ProjectController@edit');
Route::post('/project/{id}/edit','ProjectController@update');
Route::post('/project/{id}/delete','ProjectController@remove');

Route::get('/scenario/{id}','ScenarioController@index');
//Route::get('/scenario/{id}/add','ScenarioController@add');
Route::get('/scenario/{id}/add/{parent_id?}','ScenarioController@add');
Route::post('/scenario/{id}/add','ScenarioController@create');
Route::get('/scenario/{id}/detail/{this_id}','ScenarioController@detail');
Route::get('/scenario/{id}/edit/{parent_id}/{this_id}','ScenarioController@edit');
Route::post('/scenario/{id}/edit/','ScenarioController@update');
Route::post('/scenario/{id}/delete','ScenarioController@remove');

Route::get('/scenario_parameter/{id}','ScenarioParameterController@index');
Route::get('/scenario_parameter/{id}/add/{parent_id}','ScenarioParameterController@add');
Route::post('/scenario_parameter/{id}/add','ScenarioParameterController@create');
Route::get('/scenario_parameter/{id}/edit/{parent_id}/{this_id}','ScenarioParameterController@edit');
Route::post('/scenario_parameter/{id}/edit','ScenarioParameterController@update');
Route::post('/scenario_parameter/{id}/delete','ScenarioParameterController@remove');


Route::get('/scenario_script/{id}','ScenarioScriptController@index');
Route::get('/scenario_script/{id}/add/{parent_id?}','ScenarioScriptController@add');
Route::post('/scenario_script/{id}/add','ScenarioScriptController@create');
Route::get('/scenario_script/{id}/detail/{this_id}','ScenarioScriptController@detail');
Route::get('/scenario_script/{id}/edit/{parent_id}/{this_id}','ScenarioScriptController@edit');
Route::post('/scenario_script/{id}/edit','ScenarioScriptController@update');
Route::post('/scenario_script/{id}/delete','ScenarioScriptController@remove');

Route::get('/scenario_operation/{id}','ScenarioOperationController@index');
Route::get('/scenario_operation/{id}/add/{parent_id}','ScenarioOperationController@add');
Route::post('/scenario_operation/{id}/add','ScenarioOperationController@create');
Route::get('/scenario_operation/{id}/edit/{parent_id}/{this_id}','ScenarioOperationController@edit');
Route::post('/scenario_operation/{id}/edit','ScenarioOperationController@update');
Route::post('/scenario_operation/{id}/delete','ScenarioOperationController@remove');
