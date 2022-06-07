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
Route::namespace('Movie')->group(function () {
    //根据时间倒叙查找电影
    Route::apiResource('getmoviebyltime', GetMovieControllerByLTime::class);
});
//获取电影信息
Route::get('getmovieinfo/{id}', MovieController::class . '@show');

//登录
Route::apiResource('login', LoginController::class);
//注册
Route::apiResource('register', RegisterController::class);
//文件上传地址
Route::post('upload', 'CommonController@upload');
//文件下载地址
Route::get('download/{filename}', 'CommonController@download');

//获取所有电影院
Route::get('getcinema', 'CinemaController@index');
//获取电影院信息
Route::get('getcinemainfo/{id}', 'CinemaController@show');
//获取电影院电影信息
Route::post('getcinemamovie', 'CinemaController@getCinemaMovie');

//获取影厅信息
Route::post('gethellinfo/{id}', HallController::class . '@show');

//登录权限
Route::group(['middleware' => 'checkLogin'], function () {
    //用户相关信息
    Route::prefix('user')->group(function () {
        //获取用户信息
        Route::apiResource('/', UserController::class);
        //获取用户购票列表
        Route::get('getorder', 'UserController@order');
        //删除自己的评论
        Route::delete('deletecomment/{id}', 'UserController@delComment');
        //购买电影票
        Route::post('buyticket', 'TicketController@store');
        //获取单张电影票信息
        Route::get('getticket/{id}', 'TicketController@show');
    });
    // //获取用户信息
    // Route::apiResource('user', UserController::class);
    // //获取用户购票订单
    // Route::get('user/order',  UserController::class.'@order');
    //登出
    Route::apiResource('logout', LogoutController::class);
    Route::group(['middleware' => 'checkPower'], function () {
        //电影相关权限
        Route::apiResource('movie', MovieController::class);
        Route::put('movie/{id}', 'Movie\MovieController@update');
        Route::delete('movie/{id}', 'Movie\MovieController@destroy');
        //电影评论相关权限
        Route::apiResource('comments', CommentsController::class);
        //删除电影评论
        Route::delete('comments/{id}', 'CommentsController@destroy');
        // Route::get('comments', 'CommentsController@index');

    });
});