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

Route::apiResource('companies', \App\Http\Controllers\CompanyController::class);
Route::get('companies/{company}/employees', [\App\Http\Controllers\CompanyController::class, 'employees']);
//Route::get('companies/{company}/leaves', [\App\Http\Controllers\CompanyController::class, 'leaves']);
Route::apiResource('employees', \App\Http\Controllers\EmployeeController::class);
Route::apiResource('leaves', \App\Http\Controllers\LeaveController::class);
