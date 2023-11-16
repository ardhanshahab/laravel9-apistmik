<?php

use App\Http\Controllers\Api\JadwalMatakuliahController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MatakuliahController;
use App\Http\Controllers\Api\NilaiController;

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
Route::apiResource('/jadwal', App\Http\Controllers\Api\JadwalMatakuliahController::class);
Route::apiResource('/nilai', App\Http\Controllers\Api\NilaiController::class);
Route::get('/nilai/nim/{nim}',[NilaiController::class,'getNilaiByNim']);
Route::apiResource('/mahasiswa', App\Http\Controllers\Api\MahasiswaController::class);
Route::apiResource('/matakuliah', App\Http\Controllers\Api\MatakuliahController::class);
Route::get('/matakuliah/semester/{semester}',[MatakuliahController::class,'getBySemester']);
