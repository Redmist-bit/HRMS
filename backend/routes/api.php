<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Karyawan;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserMenuController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(["middleware"=>"auth.jwt"], function(){
    Route::get("karyawan", [KaryawanController::class, 'index']);
    Route::post("saya", [AuthController::class, 'saya']); // cek
    Route::post("karyawan", [KaryawanController::class, 'store']);
    Route::get('karyawan/{id}/{kode}',[KaryawanController::class,'show']);
    Route::put('karyawan/{id}/{kode}',[KaryawanController::class,'update']);
    Route::delete('karyawan/{id}/{kode}',[KaryawanController::class,'destroy']);
    Route::post("karyawanFoto/{id}/{kode}", [KaryawanController::class, 'uploadFotoKaryawan']);
    Route::get("menu", [UserMenuController::class, 'menu']); // cek
    Route::get("list", [UserMenuController::class, 'list']); // cek
    Route::put('updatemenu/{id}/{kode}',[UserMenuController::class,'updatemenu']);
    Route::get("menuselected/{usermenu}", [UserMenuController::class, 'menuselected']); // cek
    Route::post("logout", [AuthController::class, 'logout']);
    Route::delete('menu/{id}/{kode}',[UserMenuController::class,'hapusMenu']);
    Route::post("addmenu", [UserMenuController::class, 'addMenu']);
});
Route::post("login", [AuthController::class, 'login']); // register
Route::post("register", [AuthController::class, 'register']); // register
