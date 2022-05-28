<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use Movie\GetMovieController;
use Movie\MovieController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
//电影
Route::namespace('Movie')->group(function(){
    //根据时间倒叙查找电影
    Route::apiResource('getmoviebyltime',GetMovieControllerByLTime::class);
});

//登录
Route::apiResource('login',LoginController::class);
//注册
Route::apiResource('register',RegisterController::class);

//登录权限
Route::group(['middleware'=>'checkLogin'],function(){

//获取用户信息
Route::apiResource('user',UserController::class);

//登出
Route::apiResource('logout',LogoutController::class);
Route::group(['middleware'=>'checkPower'],function(){
    //电影相关权限
    Route::apiResource('movie',MovieController::class);
    Route::put('movie/{id}', 'MovieController@update');
    Route::delete('movie/{id}', 'MovieController@destroy');
});
});


