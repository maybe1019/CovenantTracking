<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Axistrustee\Compliance\Http\Controllers\CompliancetoolController;

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
Route::post('/save','Axistrustee\Compliance\Http\Controllers\CompliancetoolController@store');
Route::post('/fetchClients','Axistrustee\Compliance\Http\Controllers\CompliancetoolController@fetchClients');