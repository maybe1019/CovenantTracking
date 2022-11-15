<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Axis\Newcompliance\Http\Controllers\ComplianceController;
/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

// Route::get('/', function (Request $request) {
//     //
// });
Route::post('/store','Axis\Newcompliance\Http\Controllers\ComplianceController@save');
Route::post('/fetchClients','Axis\Newcompliance\Http\Controllers\ComplianceController@fetchClients');
Route::post('/fetchCovenant','Axis\Newcompliance\Http\Controllers\ComplianceController@fetchCovenant');
Route::post('/fetchSubtypes','Axis\Newcompliance\Http\Controllers\ComplianceController@fetchSubtypes');