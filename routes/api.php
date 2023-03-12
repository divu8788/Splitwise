<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/users', 'UserController@store');
Route::post('/groups', 'GroupController@store');
Route::post('/groups/{groupId}/users', 'GroupController@addUser');
Route::post('/groups/{groupId}/expenses', 'ExpenseController@store');
Route::get('/groups/{groupId}/expenses', 'ExpenseController@index');
Route::get('/groups/{groupId}/users/{userId}/summary', 'ExpenseController@getGroupSummary');
Route::get('/groups/{groupId}/balances', 'ExpenseController@getGroupBalances');