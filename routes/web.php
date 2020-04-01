<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('user/index','UserController@index');

//路由组
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function (){
    //后台登录页路由
    Route::get('login','LoginController@login');
    //执行登录
    Route::post('doLogin','LoginController@doLogin');
    //验证码路由
    Route::get('captcha/{tmp}', 'LoginController@captcha');
    //加密方法路由
    Route::get('crypt', 'LoginController@crypt');
});

//middleware为中间件
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'isLogin'],function (){
    //后台首页
    Route::get('index', 'LoginController@index');
    //后台欢迎页面
    Route::get('welcome', 'LoginController@welcome');
    //退出登录
    Route::get('logout', 'LoginController@logout');
});