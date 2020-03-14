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

Route::get('/scenario/{id}','ScenarioController@index');
Route::get('/scenario/{id}/add','ScenarioController@add');
Route::post('/scenario/{id}/add','ScenarioController@create');
