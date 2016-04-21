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

use App\Commands\Customer\CreateMembership;
use App\EventStore;
use Illuminate\Http\Request;

Route::get('/', 'MainController@home');

Route::post('/join', 'MainController@join');
Route::post('/add/{id}', 'MainController@add');

Route::get('/customer/{id}', 'MainController@load');
Route::get('/shop', 'MainController@shop');
Route::get('/checkout', 'MainController@checkout');