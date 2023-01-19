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
Route::get('companies/{company}/leaves', [\App\Http\Controllers\CompanyController::class, 'leaves']);
Route::apiResource('employees', \App\Http\Controllers\EmployeeController::class);
Route::get('employees/{employee}/leaves', [\App\Http\Controllers\EmployeeController::class, 'leaves']);
Route::apiResource('leaves', \App\Http\Controllers\LeaveController::class);
Route::apiResource('attendances', \App\Http\Controllers\AttendanceController::class);
Route::post('attendances/upload', [\App\Http\Controllers\AttendanceController::class, 'upload']);


Route::post('challange-02', function (Request $request){
    $array = $request->a;
    $count = array_count_values($array);
    $duplicates = [];
    foreach ($count as $key => $value){
        if($value > 1){
            $duplicates[] = $key;
        }
    }
   return responseJson('', [
       'request' => $array,
       'response' => $duplicates,
   ]);
});

Route::post('challange-04', function (Request $request){
    $array = $request->documents;

    $result = [];

    foreach($array as $key => $val) {
        $result[$val][] = $key;
    }

    return responseJson('', [
        'request' => $array,
        'response' => $result,
    ]);
});
